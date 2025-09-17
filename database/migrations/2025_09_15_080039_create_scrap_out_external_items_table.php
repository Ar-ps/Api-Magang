<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scrap_out_external_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scrap_out_external_id')->constrained('scrap_out_externals')->onDelete('cascade');
            $table->string('item_code');
            $table->integer('item_quantity');
            $table->decimal('item_unit_price', 15, 2)->default(0);
            $table->decimal('item_total_price', 15, 2)->default(0);
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scrap_out_external_items');
    }
};
