<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scrap_out_externals', function (Blueprint $table) {
            $table->id();
            $table->string('scrap_out_external_number')->unique();
            $table->date('scrap_out_external_date');
            $table->string('transaction_type'); // SELL, TRANSFER, dll
            $table->string('receiver_entity_code')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('decree_number')->nullable();
            $table->date('decree_date')->nullable();
            $table->timestamp('entry_date')->nullable();
            $table->tinyInteger('confirmation_status')->default(0);
            $table->timestamp('confirmation_date')->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scrap_out_externals');
    }
};
