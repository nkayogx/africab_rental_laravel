<?php

namespace App\Http\Controllers;

use App\Repositories\TenantRepository;
use Illuminate\Http\Request;

class OwnershipController extends Controller
{
    private $tenantRepository;
    public function __construct(TenantRepository $tenantRepository)
    {
        $this->tenantRepository = $tenantRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = $this->tenantRepository->getAll();
        // $tenants->map(function($item){
        //     $item['total_units'] = Unit::where()
        // });
        return view('ownership.index')
            ->with('owerneship',$tenants);
    }
}
