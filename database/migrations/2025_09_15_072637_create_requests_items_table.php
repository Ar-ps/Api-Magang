<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('requests')->onDelete('cascade');
            $table->string('item_code');
            $table->bigInteger('quantity');
            $table->bigInteger('received')->default(0);
            $table->string('soc_number')->nullable();
            $table->string('production_planning_number')->nullable();
            $table->string('product_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_items');
    }
};
