<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_ins', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('customs_document_code');   // contoh: BC 4.0
            $table->string('customs_document_number');
            $table->date('customs_document_date');
            $table->string('receiver_code')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('payment_type')->nullable(); // CIF / FOB / CNF
            $table->string('bl_awb_number')->nullable();
            $table->date('bl_awb_date')->nullable();
            $table->string('license_number')->nullable();
            $table->date('license_date')->nullable();
            $table->timestamp('entry_date')->nullable();
            $table->boolean('confirmation_status')->default(0);
            $table->timestamp('confirmation_date')->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_ins');
    }
};
