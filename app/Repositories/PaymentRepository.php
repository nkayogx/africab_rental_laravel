<?php

namespace App\Repositories;

use App\Repositories\InvoiceRepository;
use App\Models\Payment;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentRepository extends BaseRepository  {

    protected $model, $journalRepository, $transactionRepository, $invoiceRepository;

    /**
     * PaymentRepository constructor.
     * @param Payment $model
     * @param JournalRepository $journalRepository
     * @param TransactionRepository $transactionRepository
     * @param InvoiceRepository $invoiceRepository
     */
    function __construct(Payment $model,
                         InvoiceRepository $invoiceRepository)
    {
        $this->model = $model;
 
 
      
        $this->invoiceRepository = $invoiceRepository;
    }
 

    public function query(){
        return  $this->model->select([
             DB::raw('payments.id as payment_id'),
             DB::raw('payments.created_at as created_at'),
             DB::raw('payments.currency as currency'),
             DB::raw('payments.amount as amount'),
             DB::raw('payments.payment_status as status'),
             DB::raw('leases.lease_number as lease_number'),
             DB::raw('leases.id as lease_id'),
             DB::raw('payment_methods.payment_method_name as payment_method_name'),
             DB::raw("payment_resources.name as paid_for"),
             DB::raw('properties.property_name as property'),
            //  DB::raw('tenants.full_name as full_name'),
             DB::raw('GROUP_CONCAT(tenants.full_name) as customer'),
             DB::raw('leases.rent_amount')]
             
        )
             ->leftjoin('leases','leases.id','payments.lease_id')
             ->leftjoin('properties','properties.id','payments.property_id')
             ->leftjoin('payment_methods','payment_methods.id','payments.payment_method_id')
             ->leftjoin('payment_resources','payment_resources.id','payments.paid_for')
             ->join('lease_units','lease_units.lease_id','payments.lease_id')
             ->join('lease_tenants','lease_tenants.lease_id','leases.id')
             ->join('tenants','tenants.id','lease_tenants.tenant_id');

             
     }

     public function getAll($load = array())
     {
        return $this->query()
        ->groupby(['payments.id','tenants.full_name'])
        ->get();
     }

    /**
     * @param $walletAmount
     * @param $itemBalanceDue
     * @return int
     */
    private function calculateTransactionAmount($walletAmount, $itemBalanceDue) {
         switch ($walletAmount) {
            case  $walletAmount >= $itemBalanceDue:
                {
                    $transactionAmount = $itemBalanceDue;
                    break;
                }
            case  $walletAmount < $itemBalanceDue:
                {
                    $transactionAmount = $walletAmount;
                    break;
                }
            default: {
                $transactionAmount = 0;
            }
         }
         return $transactionAmount;
    }


    public function unitPaidAmount($unitID) {
        return DB::table('payments')
            ->select(DB::raw('COALESCE(sum(payments.amount), 0.0) as totalPaid'))
            ->where('unit_id', $unitID)
            ->first()->totalPaid;
    }

    /**
     * @param $payment
     * @param bool $newPayment
     * @throws \Exception
     */
    public function processPayment($payment, $newPayment = true) {
        try {
            DB::beginTransaction();
            if ($newPayment) {
                $this->journalRepository->receivePayment([
                    'narration'     => 'Payment Received #'.$payment['receipt_number'],
                    'property_id'   => $payment['property_id'],
                    'amount'        => $payment['amount'],
                    'reference_id'  => $payment['id'],
                    'lease_number'  => $payment['lease_number'],
                    'created_by'    => $payment['cre\ated_by']
                ]);
            }
            $this->pay($payment, $newPayment);
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            Log::info(json_encode('- ERROR - payBills - '));
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $payment
     * @param $newPayment
     * @throws \Exception
     */
    public function pay($payment)
    {
        try {
            DB::beginTransaction();
            $today = date('Y-m-d');
            $wallet = $payment['amount'];
            $leaseID = $payment['lease_id'];
            $paymentID = $payment['id'];
            do {
                $invoice = $this->invoiceRepository->oldestUnpaid($leaseID);
                if (!isset($invoice))
                    break;
                do {
                    $invoiceID = $invoice['id'];
                    $unpaidItem = "";
                    if (!isset($unpaidItem) && $invoice['paid_on'] == null) {
                        // Invoice is fully paid
                        $this->invoiceRepository->update(
                            ['paid_on' => $today],
                            $invoiceID
                        );
                       
                        break;
                    }
                } while ($wallet > 0);
            } while ($wallet > 0);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            Log::info(json_encode('- ERROR - pay - '));
            throw new \Exception($exception->getMessage());
        }
    }
}
