<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_id')->constrained('returns')->onDelete('cascade');
            $table->string('item_code');
            $table->bigInteger('quantity');
            $table->string('receipt_number')->nullable();
            $table->string('soc_number')->nullable();
            $table->string('production_planning_number')->nullable();
            $table->string('order_document_number')->nullable();
            $table->string('product_code')->nullable();
            $table->text('return_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_items');
    }
};
