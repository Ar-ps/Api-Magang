<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id(); // id lokal

            $table->unsignedBigInteger('user_id')->nullable();
            $table->dateTime('entry_date')->nullable();
            $table->string('tenant_code', 50)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
