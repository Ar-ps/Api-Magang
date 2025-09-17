<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->string('entity_code', 10)->unique();
            $table->string('entity_name');
            $table->string('entity_address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('telephone', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('country_code', 5)->nullable();
            $table->string('npwp', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
