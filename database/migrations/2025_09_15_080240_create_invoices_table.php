<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->string('cosignee_entity_code');
            $table->string('notify_party')->nullable();
            $table->string('soc_number')->nullable();
            $table->string('currency_code');
            $table->string('terms_of_payment')->nullable();
            $table->string('incoterms')->nullable();
            $table->string('loading_port')->nullable();
            $table->string('unloading_port')->nullable();
            $table->string('country_origin_code')->nullable();
            $table->string('bl_awb_number')->nullable();
            $table->decimal('freight', 15, 2)->default(0);
            $table->decimal('insurance', 15, 2)->default(0);
            $table->string('shipping_marks')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('entry_date')->nullable();
            $table->tinyInteger('confirmation_status')->default(0);
            $table->timestamp('confirmation_date')->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
