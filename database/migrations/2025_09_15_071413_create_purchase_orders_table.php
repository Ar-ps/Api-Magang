<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_document_number')->unique();
            $table->date('order_date');
            $table->date('required_date')->nullable();
            $table->string('entity_code');
            $table->string('currency_code', 10);
            $table->string('received_status')->default('ON ORDER');
            $table->timestamp('entry_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
