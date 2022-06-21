<?php
namespace App\Repositories;

use App\Models\Property;
use Illuminate\Support\Facades\DB;

class PropertyRepository extends BaseRepository
{
    protected $model,$unitRepository;

    /**
     * GuestRepository constructor.
     * @param Property $model
     */
    function __construct(Property $model,UnitRepository $unitRepository)
    {
        $this->model = $model;
        $this->unitRepository = $unitRepository;
    }


    public function query(){
        return $this->model->with('region')->select([
            DB::raw('properties.id as id'),
            DB::raw('properties.id as property_id'),
            DB::raw('properties.property_name as property_name'),
            DB::raw('companies.company_name as company_name'),
            DB::raw('properties.region_id as region_id'),
        ])
        ->join('companies','companies.id','properties.company_id');

       
    }

    public function getAll($load = array())
    {
        $data = $this->query()->get();
        $data->map(function($input){
           
            $input['vacant']  =  $this->unitRepository->getVacantUnits([],$input['property_id'])->count();
            
        });
        return $data;

    }

    
}
