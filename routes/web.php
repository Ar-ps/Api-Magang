<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SocController;
use App\Http\Controllers\BomController;
use App\Http\Controllers\ProductionPlanController;
use App\Http\Controllers\CustomInController;
use App\Http\Controllers\CustomInItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetOrderController;
use App\Http\Controllers\AssetInController;
use App\Http\Controllers\ProductionOutputController;
use App\Http\Controllers\ScrapInController;
use App\Http\Controllers\ScrapOutController;
use App\Http\Controllers\ScrapOutExternalController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PackingListController;
use App\Http\Controllers\InternalAssetController;
use App\Http\Controllers\ExternalAssetController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\GoodsReceiptController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\MutationController;
use App\Http\Controllers\RejectController;
use App\Http\Controllers\ProductionProcessController;
use App\Http\Controllers\SubContractOutController;
use App\Http\Controllers\SubContractInController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomIncomingController;
use App\Http\Controllers\CustomOutgoingController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GsnController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\ItemCategoryController;


// Dashboard
// ambil dari database (master/detail)
Route::get('/dashboard/{module}', [DashboardController::class, 'show'])->name('dashboard.module');
Route::get('/dashboard', function () {
    return redirect()->route('dashboard.module'); 
})->name('dashboard');


// Units
Route::get('units/sync', [ApiController::class, 'fetchUnits'])->name('units.sync');

// Items
Route::get('items/sync', [ApiController::class, 'fetchItems'])->name('items.sync');

// Entities
Route::get('entity/sync', [ApiController::class, 'fetchEntity'])->name('entity.sync');

// Departments
Route::get('departments/sync', [ApiController::class, 'fetchDepartments'])->name('departments.sync');

// SOC
Route::get('soc/sync', [ApiController::class, 'fetchSoc'])->name('soc.sync');

// BOM
Route::get('boms/sync', [ApiController::class, 'fetchBoms'])->name('boms.sync');

// Production Plan
Route::get('productionplans/sync', [ApiController::class, 'fetchProductionPlan'])->name('productionplans.sync');

// Purchase Order
Route::get('orders/sync', [ApiController::class, 'fetchPurchaseOrder'])->name('orders.sync');

// Goods Receipt
Route::get('goodsreceipts/sync', [ApiController::class, 'fetchGoodsReceipt'])->name('goodsreceipts.sync');

// Return
Route::get('return/sync', [ApiController::class, 'fetchReturn'])->name('return.sync');

// Request
Route::get('/requests/sync', [ApiController::class, 'fetchRequest']);

// Mutation
Route::get('mutations/sync', [ApiController::class, 'fetchMutation'])->name('mutations.sync');

// Reject
Route::get('rejects/sync', [ApiController::class, 'fetchRejects'])->name('rejects.sync');

// Production Process
Route::get('productionprocesses/sync', [ApiController::class, 'fetchProductionProcess'])->name('productionprocesses.sync');

// Sub Contract Out
Route::get('subcontractouts/sync', [ApiController::class, 'fetchSubContractOut'])->name('subcontractouts.sync');

// Sub Contract In
Route::get('subcontractins/sync', [ApiController::class, 'fetchSubContractIn'])->name('subcontractins.sync');

// Production Output
Route::get('productionoutputs/sync', [ApiController::class, 'fetchProductionOutput'])->name('productionoutputs.sync');

// Scrap In
Route::get('scrap_in/sync', [ApiController::class, 'fetchScrapIn'])->name('scrap_in.sync');

// Scrap Out
Route::get('scrap_out/sync', [ApiController::class, 'fetchScrapOut'])->name('scrap_out.sync');

// Scrap Out External
Route::get('scrap_out_externals/sync', [ApiController::class, 'fetchScrapOutExternal'])->name('scrap_out_externals.sync');

// Packing Lists
Route::get('packing-lists/sync', [ApiController::class, 'fetchPackingList'])->name('packing-lists.sync');

// sinkronisasi AssetOrder dari API eksternal
Route::get('asset-orders/sync', [ApiController::class, 'fetchAssetOrder'])->name('asset-orders.sync');

// hanya show saja
Route::resource('asset-orders', ApiController::class)->only(['show']);


// Asset In
Route::get('asset-ins/sync', [ApiController::class, 'fetchAssetIn'])
    ->name('asset-ins.sync');

Route::resource('asset-ins', ApiController::class)->only(['show']);

// Internal Assets
Route::get('internal-assets/sync', [ApiController::class, 'fetchInternalAsset'])->name('internal-assets.sync');

// External Assets
Route::get('external-assets/sync', [ApiController::class, 'fetchExternalAsset'])->name('external-assets.sync');

// Customs
Route::get('customins/sync', [ApiController::class, 'fetchCustomIns'])->name('customins.sync');

// CRM
Route::get('crm/sync', [ApiController::class, 'fetchCrm'])->name('crm.sync');

// GSN
Route::get('gsn/sync', [ApiController::class, 'fetchGsn'])->name('gsn.sync');

// Item Categories
Route::get('item-categories/sync', [ApiController::class, 'fetchItemCategories'])->name('item-categories.sync');

