<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Currency;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Region;
use App\Models\UnitMode;
use App\Models\UnitType;
use App\Repositories\PropertyRepository;
use App\Repositories\UnitRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    private $propertyRepository;
    private $unitRepository;
    public function __construct(PropertyRepository $propertyRepository,UnitRepository $unitRepository)
    {
        $this->propertyRepository = $propertyRepository;
        $this->unitRepository = $unitRepository;
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties= $this->propertyRepository->getAll('region');
        $regions = Region::get();
        $companies = Company::get();
        $propertyTypes  = PropertyType::get();
        return view('property.index')
                ->with('properties',$properties)
                ->with('regions',$regions)
                ->with('propertyTypes',$propertyTypes)
                ->with('companies',$companies);
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
            $data = $this->propertyRepository->create($request->all());
            $propety_id = $data->id;
            DB::commit();
            if($request->has('property_only'))
                return redirect()->back()->with('message','saved successfuly');

            return redirect()->route('property-units',$propety_id )->with('message','updated successfuly');
        }catch (\Exception $e){
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        return view('property.property_unit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function propertyUnits(Property $property)
    {
        $units = $this->unitRepository->query()->where('property_id',$property->id)->get();
        $vacants = $this->unitRepository->getVacantUnits([],$property->id)->count();
        $occupied = count($units) -  $vacants ;
        $unitTypes = UnitType::get();
        $currencies  = Currency::get();
        $unitModes  = UnitMode::get();
        return view('property.property_unit')
                ->with('property',$property)
                ->with('unitTypes',$unitTypes)
                ->with('currencies',$currencies)
                ->with('vacants',$vacants)
                ->with('occupied',$occupied)
                ->with('unitModes',$unitModes)
                ->with('units',$units);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function propertyUnitList(Property $property)
    {
        // $units = $this->unitRepository->query()->where('property_id',$property->id)->get();
         
        $units = $this->unitRepository->getVacantUnits([],$property->id)->get();
        return response()->json($units);
    }


    public function companyProperties(Request $company)
    {
        $properties = $this->propertyRepository->query()->select('id','property_code','property_name')->with('region')->where('company_id',$company->company)->get();
        return response()->json($properties);
    }
}
