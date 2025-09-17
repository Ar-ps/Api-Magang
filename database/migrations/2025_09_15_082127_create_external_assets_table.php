<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('external_assets', function (Blueprint $table) {
            $table->id();
            $table->string('external_asset_number')->unique(); // contoh: MOE/2509/HAT/0002
            $table->date('external_asset_date');
            $table->string('currency_code')->nullable();
            $table->string('transaction_type')->nullable(); // contoh: SELL
            $table->string('receiver_code')->nullable();
            $table->string('output_type')->nullable(); // contoh: FASILITAS
            $table->timestamp('entry_date')->nullable();
            $table->tinyInteger('confirmation_status')->default(0);
            $table->timestamp('confirmation_date')->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_assets');
    }
};
