<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_outputs', function (Blueprint $table) {
            $table->id();
            $table->string('production_output_number')->unique();
            $table->timestamp('production_output_date');
            $table->unsignedBigInteger('production_team');
            $table->unsignedBigInteger('production_building');
            $table->unsignedBigInteger('production_line');
            $table->timestamp('entry_date')->nullable();
            $table->boolean('confirmation_status')->default(false);
            $table->timestamp('confirmation_date')->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_outputs');
    }
};
