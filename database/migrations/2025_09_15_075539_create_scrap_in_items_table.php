<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scrap_in_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scrap_in_id')->constrained('scrap_ins')->onDelete('cascade');
            $table->string('item_code');
            $table->integer('quantity');
            $table->string('production_process_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scrap_in_items');
    }
};
