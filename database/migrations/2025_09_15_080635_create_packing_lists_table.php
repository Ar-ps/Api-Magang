<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packing_lists', function (Blueprint $table) {
            $table->id();
            $table->string('packing_list_number')->unique();
            $table->date('packing_list_date');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->string('cosignee_entity_code');
            $table->string('notify_party')->nullable();
            $table->string('soc_number')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('terms_of_payment')->nullable();
            $table->string('incoterms')->nullable();
            $table->string('country_origin_code')->nullable();
            $table->string('loading_port')->nullable();
            $table->string('unloading_port')->nullable();
            $table->string('bl_awb_number')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('entry_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packing_lists');
    }
};
