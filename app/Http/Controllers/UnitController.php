<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        
        try{
            DB::beginTransaction();
            $unit = Unit::create($request->all());
            DB::commit();
            return redirect()->route('property-units', $request->property_id )->with('message','saved successfuly');
        }catch (\Exception $e){
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        
       
       

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        return $unit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //
    }

    public function getPropertyUnits($property_id){
        return Unit::with('leases')->where('property_id',$property_id)->get()->toJson();

    }

    public function currentTenant($unitId){
        $date = date('Y-m-d');
       $tenants = Tenant::whereIn('tenants.id',function($query) use($unitId,$date){
                $query->select('lease_tenants.tenant_id')->from('lease_tenants')
                    ->join('leases','leases.id','lease_tenants.tenant_id')
                    ->join('lease_units','lease_units.lease_id','leases.id')
                    ->whereNull('leases.terminated_on')
                    ->Orwhere('leases.end_date','<',$date )
                    ->where('lease_units.unit_id',$unitId);
                })->select('tenants.full_name','tenants.phone','tenants.physical_address','tenants.email')->get();
       
        $lease = Lease::join('lease_units','lease_units.lease_id','leases.id')
                    ->whereNull('leases.terminated_on')
                    ->Orwhere('leases.end_date','<',$date )
                    ->select(DB::raw('DISTINCT(leases.id) as lease_id'),'lease_number','start_date','end_date','rent_amount')->where('lease_units.unit_id',$unitId)
                    ->groupby(['leases.id','lease_number'])
                    ->take(1)
                    ->first();

        $data = ['tenants'=>$tenants,'lease'=>$lease];
        
        return  response()->json($data);
    }
}
