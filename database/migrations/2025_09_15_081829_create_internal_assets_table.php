<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internal_assets', function (Blueprint $table) {
            $table->id();
            $table->string('internal_asset_number')->unique(); // contoh: MOI/2509/HAT/0001
            $table->date('internal_asset_date');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->timestamp('entry_date')->nullable();
            $table->tinyInteger('confirmation_status')->default(0); // 0=draft, 1=approved, 2=rejected
            $table->timestamp('confirmation_date')->nullable();
            $table->unsignedBigInteger('confirmation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internal_assets');
    }
};
