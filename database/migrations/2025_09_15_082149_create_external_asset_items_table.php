<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('external_asset_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('external_asset_id')->constrained('external_assets')->onDelete('cascade');
            $table->string('item_code');
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('total_price', 20, 2)->default(0);
            $table->string('order_asset_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_asset_items');
    }
};
