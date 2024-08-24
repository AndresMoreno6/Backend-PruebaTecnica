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
        Schema::create('historial', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('pais_id');
            $table->integer('ciudad_id')->index('ciudad_id');
            $table->decimal('presupuesto_cop', 15, 0);
            $table->integer('presupuesto_local');
            $table->string('clima', 50);
            $table->date('fecha')->useCurrent();

            $table->unique(['pais_id', 'ciudad_id'], 'pais_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
