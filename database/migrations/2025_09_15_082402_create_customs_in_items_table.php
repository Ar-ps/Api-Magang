<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_in_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_in_id')
                  ->constrained('custom_ins')
                  ->onDelete('cascade');
            $table->string('item_code');
            $table->bigInteger('quantity')->default(0);
            $table->decimal('unit_price', 20, 2)->default(0);
            $table->decimal('total_price', 25, 2)->default(0);
            $table->string('hs_code')->nullable();
            $table->string('series_number')->nullable();
            $table->decimal('exchange_rate', 20, 2)->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('soc_number')->nullable();
            $table->string('production_planning_number')->nullable();
            $table->string('order_document_code')->nullable();
            $table->string('product_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_in_items');
    }
};
