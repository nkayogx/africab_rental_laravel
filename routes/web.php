<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitModeController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

 

Route::group(['middleware' => ['auth']], function () {
    Route::get('/',[HomeController::class,'index'])->name('home');
    Route::get('properties/{property}/units',[PropertyController::class,'propertyUnits'])->name('property-units');
    Route::resource('properties',PropertyController::class);
    
    Route::resource('unit_modes',UnitModeController::class);
    Route::resource('units',UnitController::class);
    Route::resource('unit_types',UnitTypeController::class);
   

    Route::resource('invoices',InvoiceController::class);
    Route::resource('leases',LeaseController::class);
    Route::resource('payments',PaymentController::class);
    Route::resource('expenses',ExpenseController::class);
    Route::resource('maintenances',MaintenanceController::class);
    Route::resource('ownership',OwnershipController::class);
    Route::resource('users',UserController::class);

    Route::resource('tenants',TenantController::class);
    Route::resource('owners',OwnerController::class);


    //Ajax
    Route::get('unit_types{unitMode}/unittypemodes',[UnitTypeController::class,'unitModeTypes'])->name('unit_mode_types');
    Route::get('companies/properties',[PropertyController::class,'companyProperties'])->name('company-properties');
    Route::get('units/{property_id}/property',[UnitController::class,'getPropertyUnits'])->name('propety_units');
    Route::get('properties/{property}/unitlist',[PropertyController::class,'propertyUnitList'])->name('property-unitlist');
    Route::get('unit_current_tenant/{unitId}',[unitController::class,'currentTenant'])->name('current-tenant');

});
 
require __DIR__.'/auth.php';
