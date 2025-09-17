<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

// import semua model modul yang dibutuhkan
use App\Models\AssetOrder;
use App\Models\AssetOrderDetail;
use App\Models\AssetIn;
use App\Models\AssetInItem;
use App\Models\ProductionOutput;
use App\Models\ProductionOutputDetail;
use App\Models\ScrapIn;
use App\Models\ScrapInDetail;
use App\Models\ScrapOut;
use App\Models\ScrapOutDetail;
use App\Models\ScrapOutExternal;
use App\Models\ScrapOutExternalDetail;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Department;
use App\Models\ProductionOutputItem;
use App\Models\ScrapInItem;
use App\Models\ScrapOutItem;
use App\Models\ScrapOutExternalItem;
use App\Models\ItemCategory;
use App\Models\Mutation;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PackingList;
use App\Models\PackingListItem;
use App\Models\Entity;
use App\Models\Reject;
use App\Models\RejectItem;
use App\Models\Request;
use App\Models\RequestItem;
use App\Models\ReturnModel;
use App\Models\ReturnItem;
use App\Models\SubContractIn;
use App\Models\SubContractInItem;
// tambahkan model lain sesuai modul

class ApiController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('API_BASE_URL'),
            'timeout'  => 5000,
        ]);
        // ✅ Daftar endpoint API
        $this->endpoints = [
            'units'            => '/api/v1/units',
            'assetorder'       => '/api/v1/assetorder',
            'assetin'          => '/api/v1/asset',
            'productionoutput' => '/api/v1/productionoutput',
            'scrapin'          => '/api/v1/scrapin',
            'scrapout'         => '/api/v1/scrapout',
            'scrapoutexternal' => '/api/v1/scrapoutexternal',
            'packinglist'      => '/api/v1/packinglist',
            'bom'              => '/api/v1/bom',
            'departments'      => '/api/v1/departments',
            'soc'              => '/api/v1/soc',
            'mutation'         => '/api/v1/mutation',
            'reject'           => '/api/v1/reject',
            'request'          => '/api/v1/request',
            'retur'            => '/api/v1/retur',
            'subkonin'         => '/api/v1/subkonin',
            'subkonout'        => '/api/v1/subkonout',
            'internalasset'    => '/api/v1/internalasset',
            'externalasset'    => '/api/v1/externalasset',
            'category'         => '/api/v1/category',
            'order'            => '/api/v1/order',
            'productionplan'   => '/api/v1/productionplan',
            'productionprocess'=> '/api/v1/productionprocess',
            'customincoming'   => '/api/v1/customincoming',
            'customoutgoing'   => '/api/v1/customoutgoing',
            'crm'              => '/api/v1/crm',
            'country'          => '/api/v1/country',
            'gsn'              => '/api/v1/gsn',
            'test'             => '/api/v1/test',
            'token'            => '/api/v1/token',
            'entity'           => '/api/v1/entity',
        ];
    }

    /**
     * Utility: fetch data dari API eksternal
     */
    protected function fetchFromApi($endpoint)
    {
        $response = $this->client->get($endpoint, [
            'headers' => [
                'X-Auth-Token' => env('API_AUTH_TOKEN'),
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
            'verify' => true
        ]);

        

        return json_decode($response->getBody(), true);
    }

    /**
     * Asset Order
     */
    public function fetchAssetOrder()
    {
        $data = $this->fetchFromApi($this->endpoints['assetorder']);

        if (!empty($data['data'])) {
            DB::beginTransaction();
            try {
                foreach ($data['data'] as $row) {
                // Simpan master AssetOrder
                $asset = AssetOrder::updateOrCreate(
                    ['asset_order_number' => $row['asset_order_number']], // unique key
                    [
                        'asset_order_date'    => $row['asset_order_date'] ?? null,
                        'sender_code'         => $row['sender_code'] ?? null,
                        'reference_code'      => $row['reference_code'] ?? null,
                        'currency_code'       => $row['currency_code'] ?? null,
                        'confirmation_status' => $row['confirmation_status'] ?? null,
                        'entry_date'          => $row['entry_date'] ?? null,
                        'order_type'          => $row['order_type'] ?? null,
                    ]
                );

                // ✅ cek kalau detailnya tidak nested
                if (!empty($row['items'])) {
                    foreach ($row['items'] as $detail) {
                        AssetOrderDetail::updateOrCreate(
                            [
                                'asset_order_id' => $asset->id,
                                'item_code'      => $detail['item_code']
                            ],
                            [
                                'quantity'           => $detail['quantity'] ?? 0,
                                'unit_price'         => $detail['unit_price'] ?? 0,
                                'total_price'        => $detail['total_price'] ?? 0,
                                'received_quantity'  => $detail['received_quantity'] ?? 0,
                                'remaining_quantity' => $detail['remaining_quantity'] ?? 0,
                                'specification'      => $detail['specification'] ?? null,
                                'notes'              => $detail['notes'] ?? null,
                            ]
                        );
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }

    return response()->json(['status' => true, 'message' => 'Asset Order fetched & saved successfully']);
    }

    /**
     * Asset In
     */
    public function fetchAssetIn()
    {
        $data = $this->fetchFromApi($this->endpoints['assetin']);

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    // Simpan header Asset In
                    $assetIn = AssetIn::updateOrCreate(
                        ['asset_number' => $row['asset_number']], // gunakan nomor dokumen sebagai unik
                        [
                            'asset_date'          => $row['asset_date'],
                            'currency_code'       => $row['currency_code'],
                            'transaction_type'    => $row['transaction_type'],
                            'entry_date'          => $row['entry_date'],
                            'sender_code'         => $row['sender_code'],
                            'confirmation_status' => $row['confirmation_status'],
                            'confirmation_date'   => $row['confirmation_date'],
                            'confirmation_id'     => $row['confirmation_id'],
                        ]
                    );

                    // Simpan detail items
                    foreach ($row['detail_item'] as $detail) {
                        AssetInItem::updateOrCreate(
                            [
                                'asset_in_id' => $assetIn->id,
                                'item_code'   => $detail['item_code'], // kombinasi unik
                            ],
                            [
                                'quantity'              => $detail['quantity'],
                                'unit_price'            => $detail['unit_price'],
                                'total_price'           => $detail['total_price'],
                                'asset_order_number'    => $detail['asset_order_number'],
                                'invoice_number'        => $detail['invoice_number'],
                                'invoice_date'          => $detail['invoice_date'],
                                'customs_code'          => $detail['customs_code'],
                                'registration_number'   => $detail['registration_number'],
                                'customs_document_number' => $detail['customs_document_number'],
                                'customs_document_date'   => $detail['customs_document_date'],
                                'notes'                 => $detail['notes'],
                            ]
                        );
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Asset In fetched & saved successfully'
        ]);
    }

    /**
     * Production Output
     */
    public function fetchProductionOutput()
    {
        $data = $this->fetchFromApi($this->endpoints['productionoutput']);

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    $output = ProductionOutput::updateOrCreate(
                        ['id' => $row['id']],
                        [
                            'production_output_number' => $row['production_output_number'],
                            'production_output_date'   => $row['production_output_date'],
                            'production_team'          => $row['production_team'],
                            'production_building'      => $row['production_building'],
                            'production_line'          => $row['production_line'],
                            'entry_date'               => $row['entry_date'],
                            'confirmation_status'      => $row['confirmation_status'],
                            'confirmation_date'        => $row['confirmation_date'],
                            'confirmation_id'          => $row['confirmation_id'],
                        ]
                    );

                    foreach ($row['detail_item'] as $detail) {
                        ProductionOutputItem::updateOrCreate(
                            ['id' => $detail['id']],
                            [
                                'production_output_id' => $output->id,
                                'item_code'            => $detail['item_code'],
                                'quantity'             => $detail['quantity'],
                                'pass_quantity'        => $detail['pass_quantity'],
                                'reject_quantity'      => $detail['reject_quantity'],
                                'reject_reason'        => $detail['reject_reason'],
                                'soc_number'           => $detail['soc_number'],
                                'production_planning_number' => $detail['production_planning_number'],
                                'note'                 => $detail['note'],
                            ]
                        );
                    }
                }
            });
        }

        return response()->json(['status' => true, 'message' => 'Production Output fetched & saved successfully']);
    }

    /**
     * Scrap In
     */
    public function fetchScrapIn()
    {
        $data = $this->fetchFromApi($this->endpoints['scrapin']);

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    $scrapIn = ScrapIn::updateOrCreate(
                        ['id' => $row['id']],
                        [
                            'scrap_in_number' => $row['scrap_in_number'],
                            'scrap_in_date'   => $row['scrap_in_date'],
                            'scrap_code'      => $row['scrap_code'],
                            'quantity'        => $row['quantity'],
                            'entry_date'      => $row['entry_date'],
                            'confirmation_status' => $row['confirmation_status'],
                            'confirmation_date'   => $row['confirmation_date'],
                            'confirmation_id'     => $row['confirmation_id'],
                        ]
                    );

                    foreach ($row['detail_item'] as $detail) {
                        ScrapInItem::updateOrCreate(
                            ['id' => $detail['id']],
                            [
                                'scrap_in_id'             => $scrapIn->id,
                                'item_code'               => $detail['item_code'],
                                'quantity'                => $detail['quantity'],
                                'production_process_number'=> $detail['production_process_number'],
                                'notes'                   => $detail['notes'],
                            ]
                        );
                    }
                }
            });
        }

        return response()->json(['status' => true, 'message' => 'Scrap In fetched & saved successfully']);
    }

    /**
     * Scrap Out
     */
    public function fetchScrapOut()
    {
        $data = $this->fetchFromApi($this->endpoints['scrapout']);

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    $scrapOut = ScrapOut::updateOrCreate(
                        ['id' => $row['id']],
                        [
                            'scrap_out_number' => $row['scrap_out_number'],
                            'scrap_out_date'   => $row['scrap_out_date'],
                            'decree_number'    => $row['decree_number'],
                            'decree_date'      => $row['decree_date'],
                            'location'         => $row['location'],
                            'entry_date'       => $row['entry_date'],
                            'confirmation_status' => $row['confirmation_status'],
                            'confirmation_date'   => $row['confirmation_date'],
                            'confirmation_id'     => $row['confirmation_id'],
                        ]
                    );

                    foreach ($row['detail_item'] as $detail) {
                        ScrapOutItem::updateOrCreate(
                            ['id' => $detail['id']],
                            [
                                'scrap_out_id'            => $scrapOut->id,
                                'item_code'               => $detail['item_code'],
                                'quantity'                => $detail['quantity'],
                                'production_process_number'=> $detail['production_process_number'],
                                'notes'                   => $detail['notes'],
                            ]
                        );
                    }
                }
            });
        }

        return response()->json(['status' => true, 'message' => 'Scrap Out fetched & saved successfully']);
    }

    /**
     * Scrap Out External
     */
    public function fetchScrapOutExternal()
    {
        $data = $this->fetchFromApi($this->endpoints['scrapoutexternal']);

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    $scrapExt = \App\Models\ScrapOutExternal::updateOrCreate(
                        ['scrap_out_external_number' => $row['scrap_out_external_number']], // ✅ pakai nomor dokumen unik
                        [
                            'scrap_out_external_date'   => $row['scrap_out_external_date'] ?? null,
                            'transaction_type'          => $row['transaction_type'] ?? null,
                            'receiver_entity_code'      => $row['receiver_entity_code'] ?? null,
                            'currency_code'             => $row['currency_code'] ?? null,
                            'decree_number'             => $row['decree_number'] ?? null,
                            'decree_date'               => $row['decree_date'] ?? null,
                            'entry_date'                => $row['entry_date'] ?? null,
                            'confirmation_status'       => $row['confirmation_status'] ?? 0,
                            'confirmation_date'         => $row['confirmation_date'] ?? null,
                            'confirmation_id'           => $row['confirmation_id'] ?? null,
                        ]
                    );

                    foreach ($row['detail_item'] as $detail) {
                        \App\Models\ScrapOutExternalItem::updateOrCreate(
                            ['id' => $detail['id']],
                            [
                                'scrap_out_external_id' => $scrapExt->id,
                                'item_code'             => $detail['item_code'],
                                'item_quantity'         => $detail['item_quantity'],
                                'item_unit_price'       => $detail['item_unit_price'],
                                'item_total_price'      => $detail['item_total_price'],
                                'reference_number'      => $detail['reference_number'],
                                'notes'                 => $detail['notes'],
                            ]
                        );
                    }
                }
            });
        }

        return response()->json(['status' => true, 'message' => 'Scrap Out External fetched & saved successfully']);
    }

    /**
     * Packing List
     */
    public function fetchPackingList()
    {
        $data = $this->fetchFromApi($this->endpoints['packinglist']);

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    $pl = PackingList::updateOrCreate(
                        ['id' => $row['id']],
                        [
                            'packing_list_number'=> $row['packing_list_number'],
                            'packing_list_date'  => $row['packing_list_date'],
                            'invoice_number'     => $row['invoice_number'],
                            'invoice_date'       => $row['invoice_date'],
                            'cosignee_entity_code'=> $row['cosignee_entity_code'],
                            'notify_party'       => $row['notify_party'],
                            'soc_number'         => $row['soc_number'],
                            'currency_code'      => $row['currency_code'],
                            'terms_of_payment'   => $row['terms_of_payment'],
                            'incoterms'          => $row['incoterms'],
                            'country_origin_code'=> $row['country_origin_code'],
                            'loading_port'       => $row['loading_port'],
                            'unloading_port'     => $row['unloading_port'],
                            'bl_awb_number'      => $row['bl_awb_number'],
                            'remarks'            => $row['remarks'],
                            'entry_date'         => $row['entry_date'],
                        ]
                    );

                    foreach ($row['detail_item'] as $detail) {
                        PackingListItem::updateOrCreate(
                            ['id' => $detail['id']],
                            [
                                'packing_list_id'   => $pl->id,
                                'marks'             => $detail['marks'],
                                'item_code'         => $detail['item_code'],
                                'item_name'         => $detail['item_name'],
                                'unit_code'         => $detail['unit_code'],
                                'quantity'          => $detail['quantity'],
                                'nett_weight'       => $detail['nett_weight'],
                                'gross_weight'      => $detail['gross_weight'],
                                'measurement'       => $detail['measurement'],
                                'cbm'               => $detail['cbm'],
                                'packing_type'      => $detail['packing_type'],
                                'remarks'           => $detail['remarks'],
                            ]
                        );
                    }
                }
            });
        }

        return response()->json(['status' => true, 'message' => 'Packing List fetched & saved successfully']);
    }

    public function fetchCrm()
    {
        // pastikan ada prefix api/v1
        $data = $this->fetchFromApi($this->endpoints['crm']);

        if (!empty($data['data'])) {
            \DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    $crm = \App\Models\Crm::updateOrCreate(
                        ['crm_number' => $row['crm_number']], 
                        [
                            'interaction_date'  => $row['interaction_date'] ?? null,
                            'entity_code'       => $row['entity_code'] ?? null,
                            'interaction_media' => $row['interaction_media'] ?? null,
                            'customer_team'     => $row['customer_team'] ?? null,
                            'internal_team'     => $row['internal_team'] ?? null,
                            'negotiation'       => $row['negotiation'] ?? null,
                            'isorder'           => $row['isorder'] ?? false,
                        ]
                    );

                    if (!empty($row['detail_item'])) {
                        foreach ($row['detail_item'] as $detail) {
                            \App\Models\CrmDetail::updateOrCreate(
                                [
                                    'crm_id'  => $crm->id,
                                    'subject' => $detail['subject'] ?? null,
                                ],
                                [
                                    'description' => $detail['description'] ?? null,
                                    'status'      => $detail['status'] ?? null,
                                    'assigned_to' => $detail['assigned_to'] ?? null,
                                    'due_date'    => $detail['due_date'] ?? null,
                                ]
                            );
                        }
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'CRM data fetched & saved successfully'
        ]);
    }

    public function fetchCustomIns()
    {
        $data = $this->fetchFromApi($this->endpoints['customincoming']);

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    // Simpan master CustomIn
                    $customIn = \App\Models\CustomIn::updateOrCreate(
                        ['registration_number' => $row['registration_number']], // pakai unique
                        [
                            'customs_document_code'   => $row['customs_document_code'] ?? null,
                            'customs_document_number' => $row['customs_document_number'] ?? null,
                            'customs_document_date'   => $row['customs_document_date'] ?? null,
                            'receiver_code'           => $row['receiver_code'] ?? null,
                            'currency_code'           => $row['currency_code'] ?? null,
                            'payment_type'            => $row['payment_type'] ?? null,
                            'bl_awb_number'           => $row['bl_awb_number'] ?? null,
                            'bl_awb_date'             => $row['bl_awb_date'] ?? null,
                            'license_number'          => $row['license_number'] ?? null,
                            'license_date'            => $row['license_date'] ?? null,
                            'entry_date'              => $row['entry_date'] ?? null,
                            'confirmation_status'     => $row['confirmation_status'] ?? 0,
                            'confirmation_date'       => $row['confirmation_date'] ?? null,
                            'confirmation_id'         => $row['confirmation_id'] ?? null,
                        ]
                    );

                    // Simpan detail item
                    foreach ($row['detail_item'] ?? [] as $detail) {
                        \App\Models\CustomInItem::updateOrCreate(
                            [
                                'custom_in_id' => $customIn->id,
                                'item_code'    => $detail['item_code'],
                            ],
                            [
                                'quantity'                => $detail['quantity'] ?? 0,
                                'unit_price'              => $detail['unit_price'] ?? 0,
                                'total_price'             => $detail['total_price'] ?? 0,
                                'hs_code'                 => $detail['hs_code'] ?? null,
                                'series_number'           => $detail['series_number'] ?? null,
                                'exchange_rate'           => $detail['exchange_rate'] ?? null,
                                'invoice_number'          => $detail['invoice_number'] ?? null,
                                'invoice_date'            => $detail['invoice_date'] ?? null,
                                'soc_number'              => $detail['soc_number'] ?? null,
                                'production_planning_number' => $detail['production_planning_number'] ?? null,
                                'order_document_code'     => $detail['order_document_code'] ?? null,
                                'product_code'            => $detail['product_code'] ?? null,
                                'notes'                   => $detail['notes'] ?? null,
                            ]
                        );
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Custom In fetched & saved successfully'
        ]);
    }
    public function fetchDepartments()
    {
        // ambil data dari API
        $data = $this->fetchFromApi($this->endpoints['departments']);

        // API ternyata pakai key "date", bukan "data"
        $records = $data['data'] ?? $data['date'] ?? [];

        if (!empty($records)) {
            DB::transaction(function () use ($records) {
                foreach ($records as $row) {
                    Department::updateOrCreate(
                        ['department_code' => $row['department_code']], // unik key
                        [
                            'department_name' => $row['department_name'],
                        ]
                    );
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Departments fetched & saved successfully',
        ]);
    }
    public function fetchExternalAsset()
    {
        // ambil data dari API (gunakan endpoint dari daftar $this->endpoints)
        $data = $this->fetchFromApi($this->endpoints['externalasset']);

        // API kadang pakai key "data", kadang "date"
        $records = $data['data'] ?? $data['date'] ?? [];

        if (!empty($records)) {
            DB::transaction(function () use ($records) {
                foreach ($records as $row) {
                    // simpan header ExternalAsset
                    $extAsset = \App\Models\ExternalAsset::updateOrCreate(
                        ['external_asset_number' => $row['external_asset_number']], // gunakan nomor unik
                        [
                            'external_asset_date'  => $row['external_asset_date'] ?? null,
                            'currency_code'        => $row['currency_code'] ?? null,
                            'transaction_type'     => $row['transaction_type'] ?? null,
                            'receiver_code'        => $row['receiver_code'] ?? null,
                            'output_type'          => $row['output_type'] ?? null,
                            'entry_date'           => $row['entry_date'] ?? null,
                            'confirmation_status'  => $row['confirmation_status'] ?? 0,
                            'confirmation_date'    => $row['confirmation_date'] ?? null,
                            'confirmation_id'      => $row['confirmation_id'] ?? null,
                        ]
                    );

                    // simpan detail items
                    foreach ($row['detail_item'] ?? [] as $detail) {
                        \App\Models\ExternalAssetItem::updateOrCreate(
                            [
                                'external_asset_id' => $extAsset->id,
                                'item_code'         => $detail['item_code'],
                            ],
                            [
                                'quantity'           => $detail['quantity'] ?? 0,
                                'unit_price'         => $detail['unit_price'] ?? 0,
                                'total_price'        => $detail['total_price'] ?? 0,
                                'order_asset_number' => $detail['order_asset_number'] ?? null,
                                'notes'              => $detail['notes'] ?? null,
                            ]
                        );
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'External Asset fetched & saved successfully',
        ]);
    }
    public function fetchGsn()
    {
        $data = $this->fetchFromApi($this->endpoints['gsn']);

        $records = $data['data'] ?? $data['date'] ?? [];

        if (!empty($records)) {
            DB::transaction(function () use ($records) {
                foreach ($records as $row) {
                    // simpan header Invoice (GSN)
                    $gsn = \App\Models\Invoice::updateOrCreate(
                        ['invoice_number' => $row['invoice_number']], // gunakan nomor invoice sebagai unik
                        [
                            'invoice_date'        => $row['invoice_date'] ?? null,
                            'cosignee_entity_code'=> $row['cosignee_entity_code'] ?? null,
                            'notify_party'        => $row['notify_party'] ?? null,
                            'soc_number'          => $row['soc_number'] ?? null,
                            'currency_code'       => $row['currency_code'] ?? null,
                            'terms_of_payment'    => $row['terms_of_payment'] ?? null,
                            'incoterms'           => $row['incoterms'] ?? null,
                            'loading_port'        => $row['loading_port'] ?? null,
                            'unloading_port'      => $row['unloading_port'] ?? null,
                            'country_origin_code' => $row['country_origin_code'] ?? null,
                            'bl_awb_number'       => $row['bl_awb_number'] ?? null,
                            'freight'             => $row['freight'] ?? null,
                            'insurance'           => $row['insurance'] ?? null,
                            'shipping_marks'      => $row['shipping_marks'] ?? null,
                            'remarks'             => $row['remarks'] ?? null,
                            'entry_date'          => $row['entry_date'] ?? null,
                            'confirmation_status' => $row['confirmation_status'] ?? 0,
                            'confirmation_date'   => $row['confirmation_date'] ?? null,
                            'confirmation_id'     => $row['confirmation_id'] ?? null,
                        ]
                    );

                    // simpan detail item
                    foreach ($row['detail_item'] ?? [] as $detail) {
                        \App\Models\InvoiceItem::updateOrCreate(
                            [
                                'invoice_id' => $gsn->id,
                                'item_code'  => $detail['item_code'],
                            ],
                            [
                                'item_name'               => $detail['item_name'] ?? null,
                                'unit_code'               => $detail['unit_code'] ?? null,
                                'quantity'                => $detail['quantity'] ?? 0,
                                'unit_price'              => $detail['unit_price'] ?? 0,
                                'total_price'             => $detail['total_price'] ?? 0,
                                'soc_number'              => $detail['soc_number'] ?? null,
                                'production_planning_number' => $detail['production_planning_number'] ?? null,
                                'order_number'            => $detail['order_number'] ?? null,
                                'product_code'            => $detail['product_code'] ?? null,
                                'remarks'                 => $detail['remarks'] ?? null,
                            ]
                        );
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'GSN (Invoice) fetched & saved successfully',
        ]);
    }
    public function fetchInternalAsset()
    {
        $data = $this->fetchFromApi($this->endpoints['internalasset']); // endpoint: /api/v1/internalasset

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    // Simpan master Internal Asset
                    $internalAsset = \App\Models\InternalAsset::updateOrCreate(
                        ['internal_asset_number' => $row['internal_asset_number']], // unique key
                        [
                            'internal_asset_date'  => $row['internal_asset_date'] ?? null,
                            'department_id'        => $row['department_id'] ?? null,
                            'entry_date'           => $row['entry_date'] ?? null,
                            'confirmation_status'  => $row['confirmation_status'] ?? 0,
                            'confirmation_date'    => $row['confirmation_date'] ?? null,
                            'confirmation_id'      => $row['confirmation_id'] ?? null,
                        ]
                    );

                    // Simpan detail items
                    foreach ($row['detail_item'] ?? [] as $detail) {
                        \App\Models\InternalAssetItem::updateOrCreate(
                            [
                                'internal_asset_id' => $internalAsset->id,
                                'item_code'         => $detail['item_code'] ?? null, // unique per item
                            ],
                            [
                                'quantity'           => $detail['quantity'] ?? 0,
                                'order_asset_number' => $detail['order_asset_number'] ?? null,
                                'notes'              => $detail['notes'] ?? null,
                            ]
                        );
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Internal Asset fetched & saved successfully'
        ]);
    }

    public function fetchItemCategories()
    {
        // pastikan endpoint sudah ada di $this->endpoints['itemcategories']
        $data = $this->fetchFromApi($this->endpoints['category']);

        if (!empty($data['data'])) {
            \DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    \App\Models\ItemCategory::updateOrCreate(
                        [
                            // unique key → biasanya pakai kode kategori
                            'item_category_code' => $row['item_category_code'],
                        ],
                        [
                            'item_category_name' => $row['item_category_name'] ?? null,
                            'item_group_code'    => $row['item_group_code'] ?? null,
                            'noakhir'            => $row['noakhir'] ?? null,
                        ]
                    );
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Item Categories fetched & saved successfully'
        ]);
    }
    public function fetchMutation()
    {
        // ambil data dari API endpoint mutation
        $data = $this->fetchFromApi($this->endpoints['mutation']);

        if (!empty($data['data'])) {
            \DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    \App\Models\Mutation::updateOrCreate(
                        [
                            // unique key biasanya nomor dokumen mutasi
                            'mutation_number' => $row['mutation_number'],
                        ],
                        [
                            'mutation_date'       => $row['mutation_date'] ?? null,
                            'department_id'       => $row['department_id'] ?? null,
                            'entry_date'          => $row['entry_date'] ?? null,
                            'confirmation_status' => $row['confirmation_status'] ?? 0,
                            'confirmation_date'   => $row['confirmation_date'] ?? null,
                        ]
                    );
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Mutation data fetched & saved successfully'
        ]);
    }
    public function fetchPurchaseOrder()
    {
        $data = $this->fetchFromApi($this->endpoints['order']);
    
        if (!empty($data['data'])) {
            \DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    // Simpan Purchase Order (header)
                    $po = \App\Models\PurchaseOrder::updateOrCreate(
                        [
                            'order_document_number' => $row['order_document_number'], // unique
                        ],
                        [
                            'order_date'     => $row['order_date'] ?? null,
                            'required_date'  => $row['required_date'] ?? null,
                            'entity_code'    => $row['entity_code'] ?? null,
                            'currency_code'  => $row['currency_code'] ?? null,
                            'received_status'=> $row['received_status'] ?? null,
                            'entry_date'     => $row['entry_date'] ?? null,
                        ]
                    );
    
                    // Simpan detail items
                    if (!empty($row['detail_item'])) {
                        foreach ($row['detail_item'] as $detail) {
                            \App\Models\PurchaseOrderItem::updateOrCreate(
                                [
                                    'purchase_order_id' => $po->id,
                                    'item_code'         => $detail['item_code'],
                                ],
                                [
                                    'quantity'                 => $detail['quantity'] ?? 0,
                                    'unit_price'               => $detail['unit_price'] ?? 0,
                                    'total_price'              => $detail['total_price'] ?? 0,
                                    'received_quantity'        => $detail['received_quantity'] ?? 0,
                                    'remaining_quantity'       => $detail['remaining_quantity'] ?? 0,
                                    'soc_number'               => $detail['soc_number'] ?? null,
                                    'production_planning_number'=> $detail['production_planning_number'] ?? null,
                                    'product_code'             => $detail['product_code'] ?? null,
                                    'notes'                    => $detail['notes'] ?? null,
                                ]
                            );
                        }
                    }
                }
            });
        }
    
        return response()->json([
            'status'  => true,
            'message' => 'Purchase Order fetched & saved successfully'
        ]);
    }
    public function fetchProductionPlan()
    {
        $data = $this->fetchFromApi('/api/v1/productionplan');
    
        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    // Simpan master ProductionPlan
                    $plan = \App\Models\ProductionPlan::updateOrCreate(
                        ['planning_production_number' => $row['planning_production_number']], // unique key
                        [
                            'planning_production_date' => $row['planning_production_date'] ?? null,
                            'start_date'               => $row['start_date'] ?? null,
                            'finish_date'              => $row['finish_date'] ?? null,
                            'planning_status'          => $row['planning_status'] ?? null,
                            'entry_date'               => $row['entry_date'] ?? null,
                            'closer_id'                => $row['closer_id'] ?? null,
                            'closing_date'             => $row['closing_date'] ?? null,
                        ]
                    );
    
                    // Simpan detail items (jika ada)
                    foreach ($row['detail_item'] ?? [] as $detail) {
                        \App\Models\ProductionPlanItem::updateOrCreate(
                            [
                                'production_plan_id'       => $plan->id,
                                'finished_goods_item_code' => $detail['finished_goods_item_code'],
                            ],
                            [
                                'planning_quantity'      => $detail['planning_quantity'] ?? 0,
                                'finished_quantity'      => $detail['finished_quantity'] ?? 0,
                                'bill_of_material_number'=> $detail['bill_of_material_number'] ?? null,
                                'soc_number'             => $detail['soc_number'] ?? null,
                            ]
                        );
                    }
                }
            });
        }
    
        return response()->json([
            'status'  => true,
            'message' => 'Production Plan fetched & saved successfully'
        ]);
    }
    public function fetchItems()
    {
        $data = $this->fetchFromApi($this->endpoints['items']); // pastikan endpoint sesuai
    
        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    \App\Models\Item::updateOrCreate(
                        ['item_code' => $row['item_code']], // unik
                        [
                            'item_name'          => $row['item_name'] ?? null,
                            'unit_code'          => $row['unit_code'] ?? null,
                            'item_category_code' => $row['item_category_code'] ?? null,
                        ]
                    );
                }
            });
        }
    
        return response()->json([
            'status'  => true,
            'message' => 'Items fetched & saved successfully',
        ]);
    }
    public function fetchUnits()
    {
        $data = $this->fetchFromApi($this->endpoints['units']); // pastikan endpoint sudah benar
    
        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    \App\Models\Unit::updateOrCreate(
                        ['unit_code' => $row['unit_code']], // unik
                        [
                            'unit_name' => $row['unit_name'] ?? null,
                            'active'    => $row['active'] ?? 1,
                        ]
                    );
                }
            });
        }
    
        return response()->json([
            'status'  => true,
            'message' => 'Units fetched & saved successfully',
        ]);
    }
    public function fetchEntity()
    {
        $data = $this->fetchFromApi($this->endpoints['entity']); // pastikan endpoint API benar

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    \App\Models\Entity::updateOrCreate(
                        ['entity_code' => $row['entity_code']], // unique key
                        [
                            'entity_name'    => $row['entity_name'] ?? null,
                            'entity_address' => $row['entity_address'] ?? null,
                            'contact_person' => $row['contact_person'] ?? null,
                            'telephone'      => $row['telephone'] ?? null,
                            'fax'            => $row['fax'] ?? null,
                            'email'          => $row['email'] ?? null,
                            'country_code'   => $row['country_code'] ?? null,
                            'npwp'           => $row['npwp'] ?? null,
                        ]
                    );
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Entities fetched & saved successfully',
        ]);
    }
    public function fetchProductionProcess()
    {
        $data = $this->fetchFromApi($this->endpoints['productionprocess']); // pastikan endpoint sesuai

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {

                    // Simpan master ProductionProcess
                    $process = \App\Models\ProductionProcess::updateOrCreate(
                        ['process_document_number' => $row['process_document_number']], // unique key
                        [
                            'production_team_id'     => $row['production_team_id'] ?? null,
                            'production_building_id' => $row['production_building_id'] ?? null,
                            'production_line_id'     => $row['production_line_id'] ?? null,
                            'production_start_date'  => $row['production_start_date'] ?? null,
                            'production_end_date'    => $row['production_end_date'] ?? null,
                            'entry_date'             => $row['entry_date'] ?? null,
                            'confirmation_status'    => $row['confirmation_status'] ?? 0,
                            'confirmation_date'      => $row['confirmation_date'] ?? null,
                            'confirmation_id'        => $row['confirmation_id'] ?? null,
                        ]
                    );

                    // Simpan detail input
                    foreach ($row['inputs'] ?? [] as $input) {
                        \App\Models\ProductionInput::updateOrCreate(
                            [
                                'production_process_id' => $process->id,
                                'item_code'             => $input['item_code'] ?? null,
                            ],
                            [
                                'quantity'                  => $input['quantity'] ?? 0,
                                'waste'                     => $input['waste'] ?? 0,
                                'usage'                     => $input['usage'] ?? 0,
                                'soc_number'                => $input['soc_number'] ?? null,
                                'production_planning_number'=> $input['production_planning_number'] ?? null,
                                'order_number'              => $input['order_number'] ?? null,
                                'product_code'              => $input['product_code'] ?? null,
                                'notes'                     => $input['notes'] ?? null,
                            ]
                        );
                    }

                    // Simpan detail output process
                    foreach ($row['outputs'] ?? [] as $output) {
                        \App\Models\ProductionOutputProcess::updateOrCreate(
                            [
                                'production_process_id' => $process->id,
                                'item_code'             => $output['item_code'] ?? null,
                            ],
                            [
                                'quantity'                  => $output['quantity'] ?? 0,
                                'soc_number'                => $output['soc_number'] ?? null,
                                'production_planning_number'=> $output['production_planning_number'] ?? null,
                                'order_number'              => $output['order_number'] ?? null,
                                'product_code'              => $output['product_code'] ?? null,
                                'notes'                     => $output['notes'] ?? null,
                            ]
                        );
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Production Process fetched & saved successfully'
        ]);
    }
    public function fetchRejects()
    {
        $data = $this->fetchFromApi($this->endpoints['reject']);

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    $reject = \App\Models\Reject::updateOrCreate(
                        ['mutation_number' => $row['mutation_number']], // ✅ pakai mutation_number
                        [
                            'mutation_date'       => $row['mutation_date'] ?? null,
                            'department_id'       => $row['department_id'] ?? null,
                            'entry_date'          => $row['entry_date'] ?? null,
                            'confirmation_status' => $row['confirmation_status'] ?? 0,
                            'confirmation_date'   => $row['confirmation_date'] ?? null,
                        ]
                    );

                    foreach ($row['detail_item'] ?? [] as $detail) {
                        \App\Models\RejectItem::updateOrCreate(
                            [
                                'reject_id' => $reject->id,
                                'item_code' => $detail['item_code'],
                            ],
                            [
                                'quantity'        => $detail['quantity'] ?? 0,
                                'request_number'  => $detail['request_number'] ?? null,
                                'soc_number'      => $detail['soc_number'] ?? null,
                                'planning_number' => $detail['planning_number'] ?? null,
                                'order_number'    => $detail['order_number'] ?? null,
                                'product_code'    => $detail['product_code'] ?? null,
                                'notes'           => $detail['notes'] ?? null,
                            ]
                        );
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Reject fetched & saved successfully'
        ]);
    }
    public function fetchRequest()
    {
        $data = $this->fetchFromApi($this->endpoints['request']);

        if (!empty($data['data'])) {
            DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    // Simpan master Request
                    $request = \App\Models\Request::updateOrCreate(
                        ['request_document_number' => $row['request_document_number']], // unique key
                        [
                            'request_date'        => $row['request_date'] ?? null,
                            'needed_date'         => $row['needed_date'] ?? null,
                            'department_id'       => $row['department_id'] ?? null,
                            'entry_date'          => $row['entry_date'] ?? null,
                            'received_status'     => $row['received_status'] ?? 0,
                            'confirmation_status' => $row['confirmation_status'] ?? 0,
                            'confirmation_date'   => $row['confirmation_date'] ?? null,
                            'confirmation_id'     => $row['confirmation_id'] ?? null,
                        ]
                    );

                    // Simpan detail item jika ada
                    foreach ($row['detail_item'] ?? [] as $detail) {
                        \App\Models\RequestItem::updateOrCreate(
                            [
                                'request_id' => $request->id,
                                'item_code'  => $detail['item_code'],
                            ],
                            [
                                'quantity'                  => $detail['quantity'] ?? 0,
                                'received'                  => $detail['received'] ?? 0,
                                'soc_number'                => $detail['soc_number'] ?? null,
                                'production_planning_number'=> $detail['production_planning_number'] ?? null,
                                'product_code'              => $detail['product_code'] ?? null,
                                'notes'                     => $detail['notes'] ?? null,
                            ]
                        );
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Request fetched & saved successfully',
        ]);
    }
    public function fetchReturn()
    {
        // Panggil API → endpoint sesuai daftar di $this->endpoints
        $data = $this->fetchFromApi($this->endpoints['retur']);

        if (!empty($data['data'])) {
            \DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    // Simpan master Return
                    $retur = \App\Models\ReturnModel::updateOrCreate(
                        ['return_number' => $row['return_number']], // unique key
                        [
                            'return_date'          => $row['return_date'] ?? null,
                            'receiver_entity_code' => $row['receiver_entity_code'] ?? null,
                            'entry_date'           => $row['entry_date'] ?? null,
                            'return_status'        => $row['return_status'] ?? null,
                            'status_date'          => $row['status_date'] ?? null,
                            'approver'             => $row['approver'] ?? null,
                        ]
                    );

                    // Simpan detail items
                    if (!empty($row['detail_item'])) {
                        foreach ($row['detail_item'] as $detail) {
                            \App\Models\ReturnItem::updateOrCreate(
                                [
                                    'return_id' => $retur->id,
                                    'item_code' => $detail['item_code'],
                                ],
                                [
                                    'quantity'                 => $detail['quantity'] ?? 0,
                                    'receipt_number'           => $detail['receipt_number'] ?? null,
                                    'soc_number'               => $detail['soc_number'] ?? null,
                                    'production_planning_number'=> $detail['production_planning_number'] ?? null,
                                    'order_document_number'    => $detail['order_document_number'] ?? null,
                                    'product_code'             => $detail['product_code'] ?? null,
                                    'return_reason'            => $detail['return_reason'] ?? null,
                                ]
                            );
                        }
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Return data fetched & saved successfully'
        ]);
    }
    public function fetchSoc()
    {
    $data = $this->fetchFromApi($this->endpoints['soc']); // pastikan endpoints['soc'] = /api/v1/soc

    if (!empty($data['data'])) {
        \DB::transaction(function () use ($data) {
            foreach ($data['data'] as $row) {
                // Simpan SOC header
                $soc = \App\Models\Soc::updateOrCreate(
                    ['soc_number' => $row['soc_number']], // unique key
                    [
                        'soc_date'      => $row['soc_date'] ?? null,
                        'entity_code'   => $row['entity_code'] ?? null,
                        'currency_code' => $row['currency_code'] ?? null,
                        'delivery_date' => $row['delivery_date'] ?? null,
                        'description'   => $row['description'] ?? null,
                        'crm_number'    => $row['crm_number'] ?? null,
                        'entry_date'    => $row['entry_date'] ?? null,
                    ]
                );

                // Simpan SOC items
                if (!empty($row['detail_item'])) {
                    foreach ($row['detail_item'] as $detail) {
                        \App\Models\SocItem::updateOrCreate(
                            [
                                'soc_id'     => $soc->id,
                                'item_code'  => $detail['item_code'],
                            ],
                            [
                                'soc_number' => $soc->soc_number,
                                'quantity'   => $detail['quantity'] ?? 0,
                                'unit_price' => $detail['unit_price'] ?? 0,
                            ]
                        );
                    }
                }
            }
        });
    }

    return response()->json([
        'status'  => true,
        'message' => 'SOC data fetched & saved successfully'
    ]);
    }
    public function fetchSubContractIn()
    {
        $data = $this->fetchFromApi($this->endpoints['subkonin']); 
        // pastikan di $this->endpoints ada 'subkonin' => '/api/v1/subkonin'

        if (!empty($data['data'])) {
            \DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    // Simpan header SubContractIn
                    $subIn = \App\Models\SubContractIn::updateOrCreate(
                        ['sub_contract_in_number' => $row['sub_contract_in_number']], // unique key
                        [
                            'sub_contract_in_date'      => $row['sub_contract_in_date'] ?? null,
                            'subcontractor_entity_code' => $row['subcontractor_entity_code'] ?? null,
                            'sub_contract_out'          => $row['sub_contract_out'] ?? null,
                            'license_number'            => $row['license_number'] ?? null,
                            'license_date'              => $row['license_date'] ?? null,
                            'entry_date'                => $row['entry_date'] ?? null,
                            'confirmation_status'       => $row['confirmation_status'] ?? 0,
                            'confirmation_date'         => $row['confirmation_date'] ?? null,
                            'confirmation_id'           => $row['confirmation_id'] ?? null,
                        ]
                    );

                    // Simpan detail items
                    if (!empty($row['detail_item'])) {
                        foreach ($row['detail_item'] as $detail) {
                            \App\Models\SubContractInItem::updateOrCreate(
                                [
                                    'sub_contract_in_id' => $subIn->id,
                                    'item_code'          => $detail['item_code'] ?? null,
                                ],
                                [
                                    'quantity'               => $detail['quantity'] ?? 0,
                                    'waste'                  => $detail['waste'] ?? 0,
                                    'soc_number'             => $detail['soc_number'] ?? null,
                                    'production_planning_number' => $detail['production_planning_number'] ?? null,
                                    'order_number'           => $detail['order_number'] ?? null,
                                    'product_code'           => $detail['product_code'] ?? null,
                                    'customs_document_code'  => $detail['customs_document_code'] ?? null,
                                    'registration_number'    => $detail['registration_number'] ?? null,
                                    'customs_document_number'=> $detail['customs_document_number'] ?? null,
                                    'customs_document_date'  => $detail['customs_document_date'] ?? null,
                                    'notes'                  => $detail['notes'] ?? null,
                                ]
                            );
                        }
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Sub Contract In fetched & saved successfully'
        ]);
    }
    public function fetchSubContractOut()
    {
        $data = $this->fetchFromApi($this->endpoints['subkonout']);
        // pastikan di $this->endpoints ada: 'subkonout' => '/api/v1/subkonout'

        if (!empty($data['data'])) {
            \DB::transaction(function () use ($data) {
                foreach ($data['data'] as $row) {
                    // Simpan header SubContractOut
                    $subOut = \App\Models\SubContractOut::updateOrCreate(
                        ['sub_contract_out_number' => $row['sub_contract_out_number']], // unique key
                        [
                            'sub_contract_out_date'     => $row['sub_contract_out_date'] ?? null,
                            'subcontractor_entity_code' => $row['subcontractor_entity_code'] ?? null,
                            'work_to_do'                => $row['work_to_do'] ?? null,
                            'license_number'            => $row['license_number'] ?? null,
                            'license_date'              => $row['license_date'] ?? null,
                            'entry_date'                => $row['entry_date'] ?? null,
                            'confirmation_status'       => $row['confirmation_status'] ?? 0,
                            'confirmation_date'         => $row['confirmation_date'] ?? null,
                            'confirmation_id'           => $row['confirmation_id'] ?? null,
                        ]
                    );

                    // Simpan detail items
                    if (!empty($row['detail_item'])) {
                        foreach ($row['detail_item'] as $detail) {
                            \App\Models\SubContractOutItem::updateOrCreate(
                                [
                                    'sub_contract_out_id' => $subOut->id,
                                    'item_code'           => $detail['item_code'] ?? null,
                                ],
                                [
                                    'quantity'                 => $detail['quantity'] ?? 0,
                                    'soc_number'               => $detail['soc_number'] ?? null,
                                    'production_planning_number'=> $detail['production_planning_number'] ?? null,
                                    'order_document_number'    => $detail['order_document_number'] ?? null,
                                    'product_code'             => $detail['product_code'] ?? null,
                                    'notes'                    => $detail['notes'] ?? null,
                                ]
                            );
                        }
                    }
                }
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Sub Contract Out fetched & saved successfully'
        ]);
    }





}
