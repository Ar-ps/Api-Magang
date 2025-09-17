<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rejects', function (Blueprint $table) {
            $table->id();
            $table->string('mutation_number')->unique();
            $table->date('mutation_date');
            $table->unsignedBigInteger('department_id');
            $table->timestamp('entry_date')->nullable();
            $table->boolean('confirmation_status')->default(false);
            $table->timestamp('confirmation_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rejects');
    }
};
