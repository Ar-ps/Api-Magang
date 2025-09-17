<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_plan_id')->constrained('production_plans')->onDelete('cascade');
            $table->string('finished_goods_item_code');
            $table->integer('planning_quantity');
            $table->integer('finished_quantity')->default(0);
            $table->string('bill_of_material_number');
            $table->string('soc_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_plan_items');
    }
};
