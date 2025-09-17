<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packing_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('packing_list_id')->constrained('packing_lists')->onDelete('cascade');
            $table->string('marks')->nullable();
            $table->string('item_code');
            $table->string('item_name');
            $table->string('unit_code');
            $table->integer('quantity');
            $table->decimal('nett_weight', 15, 2)->default(0);
            $table->decimal('gross_weight', 15, 2)->default(0);
            $table->string('measurement')->nullable();
            $table->decimal('cbm', 15, 2)->default(0);
            $table->string('packing_type')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packing_list_items');
    }
};
