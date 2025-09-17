<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_processes', function (Blueprint $table) {
            $table->id(); // primary key id
            $table->string('process_document_number')->unique();
            $table->unsignedBigInteger('production_team_id');
            $table->unsignedBigInteger('production_building_id');
            $table->unsignedBigInteger('production_line_id');
            $table->dateTime('production_start_date');
            $table->dateTime('production_end_date')->nullable();
            $table->timestamp('entry_date')->nullable();
            $table->boolean('confirmation_status')->default(0);
            $table->timestamp('confirmation_date')->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->timestamps();
        });
        
        
    }

    public function down(): void
    {
        Schema::dropIfExists('production_processes');
    }
};
