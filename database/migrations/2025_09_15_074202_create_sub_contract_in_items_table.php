<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_contract_in_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_contract_in_id')->constrained('sub_contract_ins')->onDelete('cascade');
            $table->string('item_code');
            $table->bigInteger('quantity');
            $table->integer('waste')->nullable();
            $table->string('soc_number')->nullable();
            $table->string('production_planning_number')->nullable();
            $table->string('order_number')->nullable();
            $table->string('product_code')->nullable();
            $table->string('customs_document_code')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('customs_document_number')->nullable();
            $table->date('customs_document_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_contract_in_items');
    }
};
