<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_ins', function (Blueprint $table) {
            $table->id();
            $table->string('asset_number')->unique(); // contoh: MSI/2509/HAT/0001
            $table->date('asset_date');
            $table->string('currency_code')->nullable();
            $table->string('transaction_type')->nullable(); // OWN, LEASE, dll
            $table->timestamp('entry_date')->nullable();
            $table->string('sender_code')->nullable();
            $table->tinyInteger('confirmation_status')->default(0);
            $table->timestamp('confirmation_date')->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_ins');
    }
};
