<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();
            $table->date('receipt_date');
            $table->string('sender_code');
            $table->string('currency_code', 10);
            $table->timestamp('entry_date')->nullable();
            $table->boolean('confirmation_status')->default(false);
            $table->timestamp('confirmation_date')->nullable();
            $table->integer('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};
