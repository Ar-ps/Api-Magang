<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_output_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_process_id')
                  ->constrained('production_processes')
                  ->onDelete('cascade');
            $table->string('item_code');
            $table->bigInteger('quantity');
            $table->string('soc_number')->nullable();
            $table->string('production_planning_number')->nullable();
            $table->string('order_number')->nullable();
            $table->string('product_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('production_output_processes');
    }
};
