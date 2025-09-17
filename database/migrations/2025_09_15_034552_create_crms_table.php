<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crms', function (Blueprint $table) {
            $table->id();
            $table->string('crm_number')->unique();
            $table->date('interaction_date');
            $table->string('entity_code', 10);
            $table->string('interaction_media')->nullable();
            $table->string('customer_team')->nullable();
            $table->string('internal_team')->nullable();
            $table->string('negotiation')->nullable();
            $table->boolean('isorder')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crms');
    }
};
