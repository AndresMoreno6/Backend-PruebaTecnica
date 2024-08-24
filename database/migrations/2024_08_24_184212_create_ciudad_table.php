<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ciudad', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('nombre', 50);
            $table->string('moneda', 50);
            $table->string('simbolo_moneda', 50);
            $table->integer('pais_id')->index('pais_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciudad');
    }
};
