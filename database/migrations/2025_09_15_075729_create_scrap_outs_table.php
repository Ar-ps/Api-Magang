<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scrap_outs', function (Blueprint $table) {
            $table->id();
            $table->string('scrap_out_number')->unique();
            $table->date('scrap_out_date');
            $table->string('decree_number')->nullable();
            $table->date('decree_date')->nullable();
            $table->string('location')->nullable();
            $table->timestamp('entry_date')->nullable();
            $table->tinyInteger('confirmation_status')->default(0);
            $table->timestamp('confirmation_date')->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scrap_outs');
    }
};
