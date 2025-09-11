<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\SyncApiData;
use Illuminate\Support\Facades\Schedule;


Schedule::job(new SyncApiData('units', '/units'))->everyFiveMinutes();
Schedule::job(new SyncApiData('asset', '/asset'))->everyFiveMinutes();
Schedule::job(new SyncApiData('assetorder', '/assetorder'))->everyFiveMinutes();
Schedule::job(new SyncApiData('bom', '/bom'))->everyFiveMinutes();
Schedule::job(new SyncApiData('country', '/country'))->everyFiveMinutes();
Schedule::job(new SyncApiData('crm', '/crm'))->everyFiveMinutes();
Schedule::job(new SyncApiData('customincoming', '/customincoming'))->everyFiveMinutes();
Schedule::job(new SyncApiData('customoutgoing', '/customoutgoing'))->everyFiveMinutes();
Schedule::job(new SyncApiData('departments', '/departments'))->everyFiveMinutes();
Schedule::job(new SyncApiData('externalasset', '/externalasset'))->everyFiveMinutes();
Schedule::job(new SyncApiData('gsn', '/gsn'))->everyFiveMinutes();
Schedule::job(new SyncApiData('internalasset', '/internalasset'))->everyFiveMinutes();
Schedule::job(new SyncApiData('items', '/items'))->everyFiveMinutes();
Schedule::job(new SyncApiData('category', '/category'))->everyFiveMinutes();
Schedule::job(new SyncApiData('mutation', '/mutation'))->everyFiveMinutes();
Schedule::job(new SyncApiData('order', '/order'))->everyFiveMinutes();
Schedule::job(new SyncApiData('packinglist', '/packinglist'))->everyFiveMinutes();
Schedule::job(new SyncApiData('productionoutput', '/productionoutput'))->everyFiveMinutes();
Schedule::job(new SyncApiData('productionplan', '/productionplan'))->everyFiveMinutes();
Schedule::job(new SyncApiData('productionprocess', '/productionprocess'))->everyFiveMinutes();
Schedule::job(new SyncApiData('reject', '/reject'))->everyFiveMinutes();
Schedule::job(new SyncApiData('request', '/request'))->everyFiveMinutes();
Schedule::job(new SyncApiData('retur', '/retur'))->everyFiveMinutes();
Schedule::job(new SyncApiData('soc', '/soc'))->everyFiveMinutes();
Schedule::job(new SyncApiData('scrapin', '/scrapin'))->everyFiveMinutes();
Schedule::job(new SyncApiData('scrapout', '/scrapout'))->everyFiveMinutes();
Schedule::job(new SyncApiData('scrapoutexternal', '/scrapoutexternal'))->everyFiveMinutes();
Schedule::job(new SyncApiData('subkonin', '/subkonin'))->everyFiveMinutes();
Schedule::job(new SyncApiData('subkonout', '/subkonout'))->everyFiveMinutes();
Schedule::job(new SyncApiData('token', '/token'))->everyFiveMinutes();