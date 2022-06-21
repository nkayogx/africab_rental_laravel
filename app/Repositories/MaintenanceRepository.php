<?php

namespace App\Repositories;

use App\Models\Maintenance;
use App\Rental\Repositories\Contracts\MaintenanceInterface;
use App\Rental\Repositories\Contracts\PaymentInterface;
use App\Rental\Repositories\Contracts\MaintenanceItemInterface;
use App\Rental\Repositories\Contracts\TransactionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MaintenanceRepository extends BaseRepository implements MaintenanceInterface {

    protected $model;
    protected $maintenanceItemRepository;
    protected $transactionRepository;
    /**
     * CurrencyRepository constructor.
     * @param Currency $model
     */
    function __construct(Maintenance $model,MaintenanceItemInterface $maintenanceItem,TransactionInterface $transactionInterface)
    {
        $this->model = $model;
        $this->maintenanceItemRepository = $maintenanceItem;
        $this->transactionRepository = $transactionInterface;
    }
 
    public function getPendingDueMaintenance($load = array())
    { 
        if (strlen ($this->whereField()) > 0) {
            if(strlen ($this->whereValue()) < 1) {
                return $this->model
                    ->with($load)
                    ->whereRaw("current_due_amt > COALESCE(paid_amount_usd,0)")
                    ->whereNull($this->whereField())
                    ->search($this->searchFilter(), null, true, true)
                    ->orderBy($this->sortField(), $this->sortDirection())
                    ->paginate($this->limit());
            }
            return $this->model
                ->with($load)
                ->whereRaw("current_due_amt > COALESCE(paid_amount_usd,0)")
                ->where($this->whereField() ,"<", $this->whereValue())
                ->search($this->searchFilter(), null, true, true)
                ->orderBy($this->sortField(), $this->sortDirection())
                ->paginate($this->limit());
        }else {
            return $this->model
                ->whereRaw("current_due_amt > COALESCE(paid_amount_usd,0)")
                ->orderBy($this->sortField(), $this->sortDirection())
                ->paginate($this->limit());
               
        }
    }
    

    private function processRent($date, $lease, $invoiceID, $periodName)
    {
        $rentAmount = $lease['rent_amount'];
        $rentNarration = 'Rent - '.$periodName;

        // Journal entry - rent
        if ($rentAmount > 0)
            $this->journalRepository->earnRent([
                'narration'     => $rentNarration,
                'property_id'   => $lease['property_id'],
                'amount'        => $rentAmount,
                'reference_id'  => $lease['id'],
                'lease_number'  => $lease['lease_number'],
                'created_by'    => $lease['created_by']
            ]);

        // Billing for rent
        if ($rentAmount > 0)
            $this->maintenanceItemRepository->item($date, $lease, [
                'invoice_id'        => $invoiceID,
                'item_name'         => $rentNarration,
                'item_type'         => ITEM_RENT,
                'item_description'  => $rentNarration,
                'quantity'          => 1,
                'price'             => $rentAmount,
                'amount'            => $rentAmount,
                'discount'          => 0,
                'tax'               => 0,
                'tax_id'            => '',
            ]);
    }

}
