<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Invoice;
use App\Models\Property;
use App\Repositories\InvoiceRepository;
use App\Repositories\UnitRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function __construct(InvoiceRepository $invoiceInterface, UnitRepository $unitRepository  )
                                
                              
    {
        $this->invoiceRepository = $invoiceInterface;
        $this->unitRepository = $unitRepository;
       
        // $this->paymentRepository = $paymentInterface;
        $this->load = [];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::get();
        $invoices =  $this->invoiceRepository->getAll();
        $currencies = Currency::get();
        return view('invoice.index')
                ->with('currencies',$currencies)
                ->with('properties',$properties)
                ->with('invoices',$invoices);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
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
            $newInvoice = $this->invoiceRepository->create($data);

            if (!isset($newInvoice)) {
                return $this->respondNotSaved('Not Saved');
            }
            DB::commit();
            return redirect()->back()->with('message','invoice generated successfully');
        }catch (\Exception $e){
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
