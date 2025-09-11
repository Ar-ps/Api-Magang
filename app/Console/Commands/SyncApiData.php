<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use App\Models\ApiData;
use Illuminate\Support\Facades\Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncApiData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $module;
    protected $endpoint;

    public function __construct($module, $endpoint)
    {
        $this->module   = $module;
        $this->endpoint = $endpoint;
    }

    public function handle()
    {
        $client = new Client();
        $url    = env('API_BASE_URL') . $this->endpoint;

        try {
            $response = $client->get($url, [
                'headers' => [
                    'X-Auth-Token' => env('API_AUTH_TOKEN'),
                    'Accept'       => 'application/json',
                ],
                'verify' => false
            ]);

            $body   = $response->getBody();
            $result = json_decode((string) $body, true);
            $newData = $result['data'] ?? [];

            // Ambil data terakhir dari DB
            $latest = ApiData::where('module', $this->module)->latest()->first();

            // Bandingkan payload
            if (!$latest || json_encode($latest->payload) !== json_encode($newData)) {
                // Update DB
                ApiData::updateOrCreate(
                    ['module' => $this->module],
                    ['payload' => $newData]
                );

                // Kirim ke API internal
                Http::post(route('store.api.data'), [
                    'module'  => $this->module,
                    'payload' => $newData,
                ]);

                \Log::info("Data {$this->module} diperbarui dari API eksternal.");
            } else {
                \Log::info("Data {$this->module} tidak berubah, tidak ada update.");
            }

        } catch (\Exception $e) {
            \Log::error("Sync gagal untuk module {$this->module}", [
                'error' => $e->getMessage()
            ]);
        }
    }
}
