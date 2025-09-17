<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id(); // id lokal
            $table->unsignedBigInteger('api_id')->unique(); // id dari API

            $table->date('asset_date')->nullable();
            $table->dateTime('entry_date')->nullable();
            $table->string('sender_code', 50)->nullable();
            $table->string('asset_number', 100)->nullable();
            $table->string('currency_code', 20)->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->string('transaction_type', 50)->nullable();
            $table->dateTime('confirmation_date')->nullable();
            $table->boolean('confirmation_status')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
