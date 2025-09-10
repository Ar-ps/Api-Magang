<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function dashboard()
    {
        // default: tampilkan units
        return $this->module('units');
    }

    public function module($name)
    {
        // daftar semua modul & endpoint
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
        $url = env('API_BASE_URL') . $endpoints[$name];

        try {
            // semua modul pakai GET
            $response = $client->get($url, [
                'headers' => [
                    'X-Auth-Token' => env('API_AUTH_TOKEN'),
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                    'User-Agent'   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:120.0) Gecko/20100101 Firefox/120.0',
                    'Referer'      => env('APP_URL', 'http://localhost'),
                    'Origin'       => env('APP_URL', 'http://localhost'),
                    'Connection'   => 'keep-alive',
                    'Accept-Language' => 'en-US,en;q=0.9',
                    'Accept-Encoding' => 'gzip, deflate, br',
                ],
                'verify' => false
            ]);

            $body = $response->getBody();
            $data = json_decode((string) $body, true);

        } catch (\Exception $e) {
            $data = [
                'success' => 0,
                'message' => 'Error: ' . $e->getMessage(),
                'data'    => []
            ];
        }

        return view('esikat.dashboard', [
            'activeModule' => $name,
            'modules'      => array_keys($endpoints),
            'data'         => $data
        ]);
    }
}
