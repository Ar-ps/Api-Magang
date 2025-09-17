<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reject_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reject_id')->constrained('rejects')->onDelete('cascade');
            $table->string('item_code');
            $table->bigInteger('quantity');
            $table->string('request_number')->nullable();
            $table->string('soc_number')->nullable();
            $table->string('planning_number')->nullable();
            $table->string('order_number')->nullable();
            $table->string('product_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reject_items');
    }
};
