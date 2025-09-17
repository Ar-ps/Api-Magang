<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_plans', function (Blueprint $table) {
            $table->id();
            $table->string('planning_production_number')->unique();
            $table->date('planning_production_date');
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->string('planning_status')->default('PLAN'); // PLAN, RUNNING, CLOSED
            $table->timestamp('entry_date')->nullable();
            $table->unsignedBigInteger('closer_id')->nullable();
            $table->timestamp('closing_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_plans');
    }
};
