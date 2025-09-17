<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_contract_outs', function (Blueprint $table) {
            $table->id();
            $table->string('sub_contract_out_number')->unique();
            $table->date('sub_contract_out_date');
            $table->string('subcontractor_entity_code');
            $table->string('work_to_do');
            $table->string('license_number');
            $table->date('license_date');
            $table->timestamp('entry_date')->nullable();
            $table->boolean('confirmation_status')->default(false);
            $table->timestamp('confirmation_date')->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_contract_outs');
    }
};
