<?php

namespace App\Providers;

use App\Models\AssetOrderDetail;
use App\Models\AssetInDetail;
use App\Models\ProductionOutputDetail;
use App\Models\ScrapInDetail;
use App\Models\ScrapOutDetail;
use App\Models\ScrapOutExternalDetail;
use App\Models\InvoiceItem;
use App\Models\PackingListDetail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
