<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\ApiData;

class ApiController extends Controller
{
    public function dashboard()
    {
        // default tampilkan units
        return $this->module('units');
    }

    public function module($name)
    {
        $endpoints = [
            'units'            => '/units',
            'asset'            => '/asset',
            'assetorder'       => '/assetorder',
            'bom'              => '/bom',
            'country'          => '/country/architecto',
            'crm'              => '/crm',
            'customincoming'   => '/customincoming',
            'customoutgoing'   => '/customoutgoing/architecto',
            'departments'      => '/departments',
            'test'             => '/test',
            'externalasset'    => '/externalasset',
            'gsn'              => '/gsn',
            'internalasset'    => '/internalasset',
            'items'            => '/items',
            'category'         => '/category',
            'mutation'         => '/mutation',
            'order'            => '/order',
            'packinglist'      => '/packinglist',
            'productionoutput' => '/productionoutput',
            'productionplan'   => '/productionplan',
            'productionprocess'=> '/productionprocess',
            'reject'           => '/reject',
            'request'          => '/request',
            'retur'            => '/retur',
            'soc'              => '/soc',
            'scrapin'          => '/scrapin',
            'scrapout'         => '/scrapout',
            'scrapoutexternal' => '/scrapoutexternal',
            'subkonin'         => '/subkonin',
            'subkonout'        => '/subkonout',
            'token'            => '/token',
        ];

        if (!isset($endpoints[$name])) {
            abort(404, "Modul tidak ditemukan");
        }

        $client = new Client();
        $url    = env('API_BASE_URL') . $endpoints[$name];

        try {
            // 1️⃣ GET dari API eksternal
            $response = $client->get($url, [
                'headers' => [
                    'X-Auth-Token' => env('API_AUTH_TOKEN'),
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ],
                'verify' => false
            ]);

            $body   = $response->getBody();
            $result = json_decode((string) $body, true);

            // Simpan snapshot ke DB (overwrite kalau modul sudah ada)
            ApiData::updateOrCreate(
                ['module' => $name],
                ['payload' => $result['data'] ?? []]
            );

        } catch (\Exception $e) {
            \Log::error("API error for module $name", ['error' => $e->getMessage()]);
        }

        // Ambil data terakhir dari DB
        $latest = ApiData::where('module', $name)->latest()->first();

        $data = [
            'status'  => $latest ? 1 : 0,
            'message' => $latest ? 'Data loaded from DB' : 'No data found',
            'data'    => $latest ? $latest->payload : [],
        ];

        return view('esikat.dashboard', [
            'activeModule' => $name,
            'modules'      => array_keys($endpoints),
            'data'         => $data
        ]);
    }
}