<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_output_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_output_id')->constrained('production_outputs')->onDelete('cascade');
            $table->string('item_code');
            $table->bigInteger('quantity');
            $table->bigInteger('pass_quantity')->default(0);
            $table->bigInteger('reject_quantity')->default(0);
            $table->string('reject_reason')->nullable();
            $table->string('soc_number')->nullable();
            $table->string('production_planning_number')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_output_items');
    }
};
