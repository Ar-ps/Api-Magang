<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_in_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_in_id')->constrained('asset_ins')->onDelete('cascade');
            $table->string('item_code');
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('total_price', 15, 2);

            // relasi dokumen tambahan
            $table->string('asset_order_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();

            // bea cukai
            $table->string('customs_code')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('customs_document_number')->nullable();
            $table->date('customs_document_date')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_in_items');
    }
};
