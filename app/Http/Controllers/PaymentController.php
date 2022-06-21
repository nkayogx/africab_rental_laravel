<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentResource;
use App\Models\Property;
use App\Models\Currency;
use App\Models\PaymentMethod;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public $paymentRepository;
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments =  $this->paymentRepository->getAll();
        $paymentResources = PaymentResource::get();
        $properties = Property::get();
        $currencies = Currency::get();
        $paymentMethods = PaymentMethod::get();
        return view('payment.index')
                ->with('payments',$payments)
                ->with('properties',$properties)
                ->with('currencies',$currencies)
                ->with('paymentMethods',$paymentMethods)
                ->with('paymentResources',$paymentResources);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $newPayment = $this->paymentRepository->create($data);
            //check payment is lease then update invoice
            if($request->payment_resource == 1)
               // $invoice_payment = $this->paymentRepository->pay($newPayment);
            

            if (!isset($newPayment)) {
                return $this->respondNotSaved('Not Saved');
            }
            DB::commit();
            return redirect()->back()->with('message','payment saved successfully');
        }catch (\Exception $e){
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
