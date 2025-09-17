<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boms', function (Blueprint $table) {
            $table->id();
            $table->string('bill_of_material_number')->unique();
            $table->date('bill_of_material_date');
            $table->string('finished_goods_item_code');
            $table->integer('revision')->default(0);
            $table->string('soc_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boms');
    }
};
