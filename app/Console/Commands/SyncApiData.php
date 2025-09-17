<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ApiController;
use Illuminate\Console\Scheduling\Schedule;

class SyncApiData extends Command
{
    /**
     * Nama command yang dipakai di artisan
     */
    protected $signature = 'sync:api';

    /**
     * Deskripsi command
     */
    protected $description = 'Sinkronisasi semua modul dari API eksternal tiap 1 menit';

    /**
     * Jadwalkan eksekusi command (Laravel 11+ style)
     */
    public function schedule(Schedule $schedule)
    {
        // jalan tiap menit
        $schedule->command(static::class)->everyMinute();
    }

    /**
     * Eksekusi command
     */
    public function handle()
    {
        $this->info('🚀 Memulai sinkronisasi data dari API...');

        $api = new ApiController();

        // daftar semua method fetch di ApiController
        $methods = [
            'fetchUnits',
            'fetchItems',
            'fetchEntity',
            'fetchDepartments',
            'fetchSoc',
            'fetchBoms',
            'fetchProductionPlan',
            'fetchPurchaseOrder',
            'fetchGoodsReceipt',   // kalau ada
            'fetchReturn',
            'fetchRequest',
            'fetchMutation',
            'fetchRejects',
            'fetchProductionProcess',
            'fetchSubContractOut',
            'fetchSubContractIn',
            'fetchProductionOutput',
            'fetchScrapIn',
            'fetchScrapOut',
            'fetchScrapOutExternal',
            'fetchPackingList',
            'fetchAssetOrder',
            'fetchAssetIn',
            'fetchInternalAsset',
            'fetchExternalAsset',
            'fetchCustomIns',
            'fetchCustomOuts',     // kalau ada
            'fetchCrm',
            'fetchGsn',
            'fetchItemCategories',
        ];

        foreach ($methods as $method) {
            if (method_exists($api, $method)) {
                try {
                    $this->info("⏳ Menjalankan {$method}...");
                    $api->$method();
                    $this->info("✅ {$method} selesai.");
                } catch (\Exception $e) {
                    $this->error("❌ Error pada {$method}: " . $e->getMessage());
                }
            } else {
                $this->warn("⚠️ Method {$method} tidak ada di ApiController.");
            }
        }

        $this->info('🎉 Semua modul selesai disinkronisasi.');
    }
}
