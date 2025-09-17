<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_document_number')->unique();
            $table->date('request_date');
            $table->date('needed_date');
            $table->unsignedBigInteger('department_id');
            $table->timestamp('entry_date')->nullable();
            $table->string('received_status')->nullable(); // ON ORDER, PARTIAL, FULL
            $table->boolean('confirmation_status')->default(false);
            $table->timestamp('confirmation_date')->nullable();
            $table->string('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
