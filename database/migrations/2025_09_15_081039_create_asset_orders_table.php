<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_orders', function (Blueprint $table) {
            $table->id();
            $table->string('asset_order_number')->unique();
            $table->date('asset_order_date');
            $table->string('sender_code')->nullable();
            $table->string('reference_code')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('confirmation_status')->nullable(); // contoh: "ON ORDER"
            $table->timestamp('entry_date')->nullable();
            $table->string('order_type')->nullable(); // contoh: "FASILITAS"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_orders');
    }
};
