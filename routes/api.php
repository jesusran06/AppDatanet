<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRoleById;
use App\Http\Controllers\BCVController;
use App\Http\Controllers\OdiController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NapsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ItemPriceController;
use App\Http\Controllers\ParroquiasController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\InstalationController;
use App\Http\Controllers\PaidMethodsController;
use App\Http\Controllers\ServiceRequestsController;
use App\Http\Controllers\AdditionalServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});

//Route::get('draft', 'TimesheetController@getDraft');

Route::namespace('App\\Http\\Controllers\\API\V1')->group(function () {
   //users
    //Route::get('profile', 'ProfileController@profile');
    //Route::put('profile', 'ProfileController@updateProfile');
    Route::resource('user', UserController::class);
    //Users
    Route::get('user/role/{role_id}', 'UserController@getByRole');
    Route::get('users/filter/{value?}', 'UserController@filter')->middleware('roleById:1,3,4,6,7,8');
    Route::get('/seller', 'UserController@getSeller');
    Route::get('/instalator', 'UserController@getInstalator');
    
});


//Route::get('list', [PlansController::class, 'index'])->name('list');
Route::middleware('auth:api')->group(function (){
    
    // Planes
    Route::get('plan/list', [PlansController::class, 'index'])->name('list')->middleware('roleById:1,2,3,4,5,6,7,8');
    Route::post('plan/store', [PlansController::class, 'store'])->name('store')->middleware('roleById:1,3,7');
    Route::put('plan/update/{id}', [PlansController::class, 'update'])->name('update')->middleware('roleById:1,3,7');
    Route::get('plan/filter/{value?}', [PlansController::class, 'filterPlans'])->name('filterPlans')->middleware('roleById:1,3,7');
    Route::delete('plan/delete/{id}', [PlansController::class, 'delete'])->name('delete')->middleware('roleById:1,3,7');
    // Sectors
    Route::get('sector/list', [SectorController::class, 'index'])->name('listSector')->middleware('roleById:1,2,3,4,5,6,7,8');
    Route::get('sector/filter/{value?}', [SectorController::class, 'filter'])->name('filterSector')->middleware('roleById:1,2,3,4,5,6,7,8');
    Route::get('sector/getSelect/{id?}', [SectorController::class, 'GetSelect'])->middleware('roleById:1,2,3,4,5,6,7,8');
    Route::get('sector/getSubSelect/{id?}', [SectorController::class, 'GetSubSelect'])->middleware('roleById:1,2,3,4,5,6,7,8');
    Route::post('sector/saveSector', [SectorController::class, 'storeSector'])->name('sectorStore')->middleware('roleById:1,3,7');
    Route::delete('sector/deleteSector/{id?}', [SectorController::class, 'deleteSector'])->name('deleteSector')->middleware('roleById:1,3,7');
    // Naps
    Route::get('nap/list', [NapsController::class, 'index'])->name('list-naps')->middleware('roleById:1,2,3,4,5,6,7,8');
    Route::get('nap/filter/{value?}', [NapsController::class, 'filter'])->name('filter-nap')->middleware('roleById:1,2,3,4,5,6,7,8');
    Route::post('nap/create', [NapsController::class, 'Create'])->middleware('roleById:1,3,7');
    Route::put('nap/update/{id?}', [NapsController::class, 'Update'])->middleware('roleById:1,3,7');
    Route::put('nap/deleteNap/{id?}', [NapsController::class, 'Delete'])->middleware('roleById:1,3,7');
    Route::delete('nap/deleteSector/{id?}', [NapsController::class, 'deleteSector'])->name('deleteSector')->middleware('roleById:1,3,7');
    Route::get('nap/all', [NapsController::class, 'getAll'])->name('getAll')->middleware('roleById:1,2,3,4,5,6,7,8');


    // Roles
    Route::resources([
        'roles' => RolesController::class,
    ]);


    // Service Request
    //Route::middleware(['auth'])->group(function () {
        Route::get('request/list', [ServiceRequestsController::class, 'index'])->name('solicitudes')->middleware('roleById:1,2,3,7,8');
        Route::get('request/listApproved', [ServiceRequestsController::class, 'list_approved'])->name('list_approved')->middleware('roleById:1,2,3,7,8');
        Route::post('request/store', [ServiceRequestsController::class, 'store'])->name('store')->middleware('roleById:1,2,3');
        Route::delete('request/delete/{id?}', [ServiceRequestsController::class, 'destroy'])->name('delete')->middleware('roleById:1,2,3,7');
        Route::put('request/update/{id?}', [ServiceRequestsController::class, 'update'])->middleware('roleById:1,2,3,7');
        Route::get('request/filterAllSales/{value?}', [ServiceRequestsController::class, 'filterAllSales'])->name('filterAllSales');
        Route::get('request/filterSalesApproved/{value?}', [ServiceRequestsController::class, 'filterSalesApproved'])->name('filterSalesApproved');
        Route::post('request/report_sales', [ServiceRequestsController::class, 'salesReport'])->middleware('roleById:1,2,3,7');
        Route::post('request/export', [ServiceRequestsController::class, 'export_report'])->middleware('roleById:1,2,3,7');
    //});
    
    //Route::resource('request', erviceRequestsController::class)->only(['index', '']);
    //Item Prices
    Route::resource('itemprice', ItemPriceController::class)->only(['index'])->middleware('roleById:1,2,3,4,5,6,7,8');

    // Rutas Ubicacion
    Route::resource('parroquias', ParroquiasController::class)->only(['index'])->middleware('roleById:1,2,3,4,5,7,8');
    Route::get('parroquias/getwithsectors', [SectorController::class, 'getwithsectors'])->middleware('roleById:1,2,3,4,5,6,7,8');
    
    // Rutas Metodos de Pago
    Route::resource('methods', PaidMethodsController::class)->only(['index', 'store', 'update', 'delete']);

    // Rutas Naps
    Route::resource('naps', NapsController::class)->only(['index', 'store', 'update', 'delete']);

    // BCV
    Route::get('bcv', [BCVController::class, 'getBCV'])->name('bcv');

    //Instalations
    Route::resource('instalations', InstalationController::class)->only(['index', 'store', 'update', 'delete'])->middleware('roleById:1,3,4,5,6,7,8');
    Route::get('active-instalations', [InstalationController::class, 'getActives'])->name('active-instalations');

    //New Contracts
    Route::post('approve-sale', [ContractController::class, 'approve_sale'])->name('approve_sale')->middleware('roleById:1,3,7');

    
    //Odis
    //Route::middleware(['auth'])->group(function () {
        Route::resource('odis', OdiController::class)->only(['delete'])->middleware('roleById:[1,3,4,5,6,7,8]');
        Route::get('odis', [OdiController::class, 'index'])->middleware('roleById:1,3,4,5,6,7,8');
        Route::get('odis-form/{id}', [OdiController::class, 'odiGenerate'])->name('odis-form')->middleware('roleById:1,3,4,6,7,8');
        Route::put('odis/update/{id?}', [OdiController::class, 'update'])->middleware('roleById:1,3,4,5,6,7,8');
        Route::put('odis/finish/{id?}', [OdiController::class, 'finish'])->middleware('roleById:1,3,4,5,6,7,8');
        Route::put('odis/set-instalator/{id?}', [OdiController::class, 'setInstalator'])->middleware('roleById:1,3,4,6,7,8');
        Route::get('odis/listApproved', [OdiController::class, 'listApproved'])->name('odi-approved')->middleware('roleById:1,3,4,5,6,7,8');
        Route::get('odis/byContract/{contract_id?}',[OdiController::class, 'odiByContract'])->name('odi-by-constract')->middleware('roleById:1,3,4,5,6,7,8');
        Route::put('odis/approve-odi/{id}', [OdiController::class, 'approve'])->middleware('roleById:1,3,4,6,7,8');
        Route::post('odis/assing-group', [OdiController::class, 'assingGroup'])->name('assing-group')->middleware('roleById:1,3,4,6,7,8');
        Route::get('odis/filter/{value?}', [OdiController::class, 'filter'])->middleware('roleById:1,3,4,5,6,7,8');
        Route::get('odis/filterA/{value?}', [OdiController::class, 'filter_approved'])->middleware('roleById:1,3,4,5,6,7,8');
        Route::post('odis/report_odi', [OdiController::class, 'odiReport'])->middleware('roleById:1,6,8');
        Route::post('odis/export', [OdiController::class, 'export_report'])->middleware('roleById:1,6,8');
        Route::get('odis/{id?}', [OdiController::class, 'getById'])->name('contract-by-id')->middleware('roleById:1,6,8');
    //});
    //Servicios Adicionales
    Route::resource('services', AdditionalServiceController::class)->only(['index']);

    //Contratos
    //Route::middleware(['auth'])->group(function () {
        Route::resource('contracts', ContractController::class)->only(['index', 'store', 'update', 'delete'])->middleware('roleById:1,3,4,6,7');
        Route::get('contract/{id?}', [ContractController::class, 'getById'])->name('contract-by-id')->middleware('roleById:1,3,4,6,7');
        Route::get('contracts/filter/{value?}', [ContractController::class, 'filter'])->name('filter')->middleware('roleById:1,3,4,6,7');
    //});    
    //Usuarios

    Route::get('/operators', [OperatorController::class, 'index']);
    
});
//
//Route::get('/send_mail', [MailController::class, 'send_mails']);
