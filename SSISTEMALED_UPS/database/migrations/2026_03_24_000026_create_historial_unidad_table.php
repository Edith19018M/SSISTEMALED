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
        Schema::create('historial_unidad', function (Blueprint $table) {
            $table->id('id_historial');
            $table->unsignedBigInteger('id_unidad');
            $table->dateTime('fecha');
            $table->text('descripcion_cambio');
            $table->timestamps();
            
            $table->foreign('id_unidad')->references('id_unidad')->on('unidades_productivas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_unidad');
    }
};
