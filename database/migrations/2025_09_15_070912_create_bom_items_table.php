<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bom_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_id')->constrained('boms')->onDelete('cascade');
            $table->string('raw_material_item_code');
            $table->decimal('scrap', 10, 2)->default(0);
            $table->decimal('quantity', 15, 2);
            $table->decimal('consumption', 20, 6);
            $table->string('soc_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bom_items');
    }
};
