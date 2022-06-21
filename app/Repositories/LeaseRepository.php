<?php

namespace App\Repositories;

use App\Models\Lease;
use App\Rental\Repositories\Contracts\PeriodInterface;
use App\Rental\Repositories\Contracts\ReadingInterface;
use App\Rental\Repositories\Contracts\TransactionInterface;
use App\Rental\Repositories\Contracts\UnitInterface;
use Illuminate\Support\Facades\DB;

class LeaseRepository extends BaseRepository
{
    protected $model;

    function __construct(Lease $model)
    {
        $this->model = $model;
    }

    public function query(){
       return  $this->model->select([
            DB::raw('leases.id as id'),
            DB::raw('properties.property_name as property'),
            DB::raw('leases.lease_number as lease_number'),
            DB::raw('leases.start_date as start'),
            DB::raw('leases.end_date as end'),
            DB::raw('leases.rent_amount'),
            DB::raw('group_concat(units.unit_name) as unit'),
            DB::raw('group_concat(tenants.full_name) as customer'),
            ]
            )
            ->join('lease_units','lease_units.lease_id','leases.id')
            ->join('units','units.id','lease_units.unit_id')
            ->join('lease_tenants','lease_tenants.lease_id','leases.id')
            ->join('tenants','tenants.id','lease_tenants.tenant_id')
            ->join('properties','properties.id','leases.property_id');
    }

    public function getAll($load = array()){
        return $this->query()->groupby(['lease_units.lease_id','lease_tenants.lease_id','leases.id','properties.property_name','leases.start_date','leases.rent_amount','properties.id'])->get();
    }

    public function upload($file){

        $file->has($file);

    }
}
