<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('extension');
            $table->string('department');
            $table->string('description')->nullable();
            $table->boolean('is_easter_egg')->default(false);
            $table->string('easter_egg_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_numbers');
    }
};
