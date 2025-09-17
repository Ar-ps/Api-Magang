<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_contract_ins', function (Blueprint $table) {
            $table->id();
            $table->string('sub_contract_in_number')->unique();
            $table->date('sub_contract_in_date');
            $table->string('subcontractor_entity_code');
            $table->string('sub_contract_out')->nullable();
            $table->string('license_number')->nullable();
            $table->date('license_date')->nullable();
            $table->timestamp('entry_date')->nullable();
            $table->boolean('confirmation_status')->default(false);
            $table->timestamp('confirmation_date')->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_contract_ins');
    }
};
