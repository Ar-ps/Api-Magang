<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->string('return_number')->unique();
            $table->date('return_date');
            $table->string('receiver_entity_code');
            $table->timestamp('entry_date')->nullable();
            $table->boolean('return_status')->default(false);
            $table->timestamp('status_date')->nullable();
            $table->string('approver')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
