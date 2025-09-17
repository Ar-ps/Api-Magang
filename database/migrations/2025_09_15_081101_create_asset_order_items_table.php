<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_order_id')->constrained('asset_orders')->onDelete('cascade');
            $table->string('item_code');
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->integer('received_quantity')->default(0);
            $table->integer('remaining_quantity')->default(0);
            $table->text('specification')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_order_items');
    }
};
