<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard untuk modul tertentu
     */
    public function show(Request $request, $module = 'assetorder')
    {
        $viewType = $request->query('view', 'master');

        // daftar modul → untuk sidebar navigasi
        $modules = [
            'units','assetorder','assetin','bom','country','crm',
            'customincoming','customoutgoing','departments','entity',
            'externalasset','gsn','internalasset','items','itemcategory',
            'mutation','order','packinglist','productionoutput',
            'productionplan','productionprocess','reject','request',
            'return','soc','scrapin','scrapout','scrapoutexternal',
            'subkonin','subkonout',
        ];

        // mapping modul → fungsi sync ApiController
        $syncMap = [
            'units'             => 'fetchUnits',
            'items'             => 'fetchItems',
            'assetorder'        => 'fetchAssetOrder',
            'assetin'           => 'fetchAssetIn',
            'bom'               => 'fetchBoms',
            'entity'            => 'fetchEntity',
            'country'           => 'fetchCountries',
            'crm'               => 'fetchCrm',
            'customincoming'    => 'fetchCustomIns',
            'customoutgoing'    => 'fetchCustomOuts',
            'departments'       => 'fetchDepartments',
            'externalasset'     => 'fetchExternalAsset',
            'gsn'               => 'fetchGsn',
            'internalasset'     => 'fetchInternalAsset',
            'itemcategory'      => 'fetchItemCategories',
            'mutation'          => 'fetchMutation',
            'order'             => 'fetchPurchaseOrder',
            'packinglist'       => 'fetchPackingList',
            'productionoutput'  => 'fetchProductionOutput',
            'productionplan'    => 'fetchProductionPlan',
            'productionprocess' => 'fetchProductionProcess',
            'reject'            => 'fetchRejects',
            'request'           => 'fetchRequest',
            'return'            => 'fetchReturn',
            'soc'               => 'fetchSoc',
            'scrapin'           => 'fetchScrapIn',
            'scrapout'          => 'fetchScrapOut',
            'scrapoutexternal'  => 'fetchScrapOutExternal',
            'subkonin'          => 'fetchSubContractIn',
            'subkonout'         => 'fetchSubContractOut',
        ];

        // mapping modul ke model master
        $modelMap = [
            'units'             => \App\Models\Unit::class,
            'items'             => \App\Models\Item::class,
            'assetorder'        => \App\Models\AssetOrder::class,
            'productionoutput'  => \App\Models\ProductionOutput::class,
            'assetin'           => \App\Models\AssetIn::class,
            'bom'               => \App\Models\Bom::class,
            'entity'            => \App\Models\Entity::class,
            'country'           => \App\Models\Country::class,
            'crm'               => \App\Models\Crm::class,
            'customincoming'    => \App\Models\CustomIn::class,
            'customoutgoing'    => \App\Models\CustomOut::class,
            'departments'       => \App\Models\Department::class,
            'externalasset'     => \App\Models\ExternalAsset::class,
            'gsn'               => \App\Models\Invoice::class,
            'internalasset'     => \App\Models\InternalAsset::class,
            'itemcategory'      => \App\Models\ItemCategory::class,
            'mutation'          => \App\Models\Mutation::class,
            'order'             => \App\Models\PurchaseOrder::class,
            'packinglist'       => \App\Models\PackingList::class,
            'productionplan'    => \App\Models\ProductionPlan::class,
            'productionprocess' => \App\Models\ProductionProcess::class,
            'reject'            => \App\Models\Reject::class,
            'request'           => \App\Models\Request::class,
            'return'            => \App\Models\ReturnModel::class,
            'soc'               => \App\Models\Soc::class,
            'scrapin'           => \App\Models\ScrapIn::class,
            'scrapout'          => \App\Models\ScrapOut::class,
            'scrapoutexternal'  => \App\Models\ScrapOutExternal::class,
            'subkonin'          => \App\Models\SubContractIn::class,
            'subkonout'         => \App\Models\SubContractOut::class,
        ];

        // mapping modul ke model detail
        $detailMap = [
            'assetorder'        => \App\Models\AssetOrderItem::class,
            'assetin'           => \App\Models\AssetInItem::class,
            'productionoutput'  => \App\Models\ProductionOutputItem::class,
            'scrapin'           => \App\Models\ScrapInItem::class,
            'scrapout'          => \App\Models\ScrapOutItem::class,
            'scrapoutexternal'  => \App\Models\ScrapOutExternalItem::class,
            'gsn'               => \App\Models\InvoiceItem::class,
            'packinglist'       => \App\Models\PackingListItem::class,
            'customincoming'    => \App\Models\CustomInItem::class,
            'customoutgoing'    => \App\Models\CustomOutItem::class,
            'externalasset'     => \App\Models\ExternalAssetItem::class,
            'order'             => \App\Models\PurchaseOrderItem::class,
            'reject'            => \App\Models\RejectItem::class,
            'request'           => \App\Models\RequestItem::class,
            'return'            => \App\Models\ReturnItem::class,
            'soc'               => \App\Models\SocItem::class,
            'subkonin'          => \App\Models\SubContractInItem::class,
            'subkonout'         => \App\Models\SubContractOutItem::class,
        ];

        /**
         * 🔥 Auto-sync: jalankan fungsi fetch sebelum ambil data dari DB
         */
        if (isset($syncMap[$module])) {
            try {
                $api = new \App\Http\Controllers\ApiController();
                $method = $syncMap[$module];
                if (method_exists($api, $method)) {
                    $api->$method();
                }
            } catch (\Exception $e) {
                \Log::error("Sync gagal untuk modul {$module}: " . $e->getMessage());
            }
        }

        // ambil data dari DB
        if ($viewType === 'detail' && isset($detailMap[$module])) {
            $records = $detailMap[$module]::all()->toArray();
        } elseif (isset($modelMap[$module])) {
            $records = $modelMap[$module]::all()->toArray();
        } else {
            $records = [];
        }

        $totalRecords = count($records);

        // cek data nested
        $hasComplexData = collect($records)->contains(function ($row) {
            return collect($row)->contains(fn($val) => is_array($val));
        });

        return view('esikat.dashboard', [
            'activeModule'   => $module,
            'records'        => $records,
            'totalRecords'   => $totalRecords,
            'modules'        => $modules,
            'hasComplexData' => $hasComplexData,
            'detailMap'      => $detailMap,
        ]);
    }
}
