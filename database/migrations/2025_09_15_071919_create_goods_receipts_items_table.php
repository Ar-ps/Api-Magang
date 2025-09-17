<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goods_receipt_id')->constrained('goods_receipts')->onDelete('cascade');
            $table->string('item_code');
            $table->bigInteger('quantity');
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('soc_number')->nullable();
            $table->string('production_planning_number')->nullable();
            $table->string('order_document_number')->nullable();
            $table->string('product_code')->nullable();
            $table->string('custom_document_code')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('custom_document_number')->nullable();
            $table->date('custom_document_date')->nullable();
            $table->text('receipt_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_items');
    }
};
