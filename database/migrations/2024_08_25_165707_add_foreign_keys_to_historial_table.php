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
        Schema::table('historial', function (Blueprint $table) {
            $table->foreign(['pais_id'], 'historial_ibfk_1')->references(['id'])->on('pais')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['ciudad_id'], 'historial_ibfk_2')->references(['id'])->on('ciudad')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial', function (Blueprint $table) {
            $table->dropForeign('historial_ibfk_1');
            $table->dropForeign('historial_ibfk_2');
        });
    }
};
