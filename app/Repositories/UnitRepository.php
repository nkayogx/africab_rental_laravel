<?php
namespace App\Repositories;

use App\Models\Unit;

class UnitRepository extends BaseRepository
{
    protected $model;

    /**
     * GuestRepository constructor.
     * @param Unit $model
     */
    function __construct(Unit $model)
    {
        $this->model = $model;
    }

    public function query(){
        return $this->model;
    }

    public function limit(){
        return (int)(request()->query('limit')) ? : 3;
    }

    public function isVacant($unit)
    {
        if ($this->unitLease($unit['property_id'])->where('units.id',$unit['id'])->count()) {
            return false;
        }
        return true;

    }

    public function unitLease($propertyID) {
        
        if (isset($propertyID)) {
            return  $this->model
                    ->where('leases.terminated_on', null)
                    ->where('leases.property_id', $propertyID)
                    ->join('lease_units', 'lease_units.unit_id', 'units.id')
                    ->join('leases','leases.id','lease_units.lease_id');
 
        }
    }

    public function freeUnits($propertyID) {
        $date = date('Y-m-d');
        if (isset($propertyID)) {
            return  $this->model
                    ->whereNotIn('units.id', function($query) use ($date){
                        $query->select(\DB::raw("unit_id"))->from('lease_units')
                                ->join('leases','leases.id','lease_units.lease_id')
                                ->whereNull('leases.terminated_on')
                                ->OrWhere('end_date','>',$date);
                    })->where('units.property_id',$propertyID);
                   
                     
        }
    }

    public function occupiedUnits($propertyID) {
        $date = date('Y-m-d');
        if (isset($propertyID)) {
            return  $this->model
                    ->whereIn('units.id', function($query) use ($date){
                        $query->select(\DB::raw("unit_id"))->from('lease_units')
                                ->join('leases','leases.id','lease_units.lease_id')
                                ->whereNotNull('leases.terminated_on')
                                ->OrWhere('end_date','<',$date);
                    })->where('units.property_id',$propertyID);
                    
                     
        }
    }

    

    /**
     * @param array $load
     * @param string $landlordID
     * @param string $propertyID
     * @return mixed
     */
    public function getVacantUnits($load = array(), $propertyID = '')
    {
        return $this->freeUnits($propertyID)->select('units.*');
    }   
    public function getOccupiedUnits($load = array(), $propertyID = '')
    {
        return $this->occupiedUnits($propertyID)->select('units.*');
    }   


    // public function getOccupiedUnits($load = array(), $landlordID = '', $propertyID = '')
    // {
    //     if (strlen ($this->whereField()) > 0) {
    //         if(strlen ($this->whereValue()) < 1) {           
    //             return $this->model
    //                 ->with($load)
    //                 ->whereNull($this->whereField())
    //                 ->withCount('leases')
    //                 ->search($this->searchFilter(), null, true, true)
    //                 ->orderBy($this->sortField(), $this->sortDirection())
    //                 ->paginate($this->limit());
    //         }       
    //         return $this->model
    //             ->with($load)
    //             ->where($this->whereField(), $this->whereValue())
    //             ->withCount('leases')
    //             ->orderBy($this->sortField(), $this->sortDirection())
    //             ->having('leases_count', '>', 0)
    //             ->paginate($this->limit());
    //     }else {
    //         return $this->model
    //             ->with($load)
    //             ->withCount('leases')
    //             ->search($this->searchFilter(), null, true, true)
    //             ->orderBy($this->sortField(), $this->sortDirection())
    //             ->having('leases_count', '>', 0)
    //             ->paginate($this->limit());
    //     }
    // }  
}
