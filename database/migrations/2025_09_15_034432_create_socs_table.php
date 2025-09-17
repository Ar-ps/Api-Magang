<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('socs', function (Blueprint $table) {
            $table->id();
            $table->string('soc_number')->unique();
            $table->date('soc_date');
            $table->string('entity_code', 10);
            $table->string('currency_code', 10);
            $table->date('delivery_date')->nullable();
            $table->text('description')->nullable();
            $table->string('crm_number')->nullable();
            $table->timestamp('entry_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('socs');
    }
};
