<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Lease;
use App\Models\Currency;
use App\Models\Tenant;
use App\Repositories\LeaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaseController extends Controller
{
    public $leaseRepository;
    public function __construct(LeaseRepository $leaseRepository)
    {
        $this->leaseRepository = $leaseRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $leases =  $this->leaseRepository->getAll([]);
        $currencies  = Currency::get();
        $companies  = Company::get();
        $customers = Tenant::get();
        return view('lease.index')
                ->with('leases',$leases)
                ->with('companies',$companies)
                ->with('customers',$customers)
                ->with('currencies',$currencies);
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
        $data = $request->all();
   
        try{
            DB::beginTransaction();
                $newLease = $this->leaseRepository->create($data);
                if(array_key_exists('customer_id', $data)) {
                    $tenantsData = $data['customer_id'];
                    if (isset($tenantsData)){
                        foreach ($tenantsData as $key => $id) {
                             $newLease->tenants()->attach( ['tenant_id' => $id] );
                           
                        }
                    }
                }
        
                if(array_key_exists('unit_id', $data)) {
                    $unitsData = $data['unit_id'];
                    if (isset($unitsData)){
                        foreach ($unitsData as $key => $id) {
                            $newLease->units()->attach(['unit_id'   => $id] );
                           
                        }
                    }
                }
            
            DB::commit();
            return redirect()->route('leases.index')->with('message','submitted successfully');
        }catch (\Exception $e){
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lease  $lease
     * @return \Illuminate\Http\Response
     */
    public function show(Lease $lease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lease  $lease
     * @return \Illuminate\Http\Response
     */
    public function edit(Lease $lease)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lease  $lease
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lease $lease)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lease  $lease
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lease $lease)
    {
        //
    }
}
