<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soc_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soc_id')->constrained('socs')->onDelete('cascade');
            $table->string('soc_number');
            $table->string('item_code');
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soc_items');
    }
};
