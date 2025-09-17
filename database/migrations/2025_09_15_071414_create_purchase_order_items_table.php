<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
            $table->string('item_code');
            $table->bigInteger('quantity');
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('total_price', 20, 2)->default(0);
            $table->bigInteger('received_quantity')->default(0);
            $table->bigInteger('remaining_quantity')->default(0);
            $table->string('soc_number')->nullable();
            $table->string('production_planning_number')->nullable();
            $table->string('product_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
