<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internal_asset_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internal_asset_id')->constrained('internal_assets')->onDelete('cascade');
            $table->string('item_code');
            $table->integer('quantity');
            $table->string('order_asset_number')->nullable(); // referensi dari POM/...
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internal_asset_items');
    }
};
