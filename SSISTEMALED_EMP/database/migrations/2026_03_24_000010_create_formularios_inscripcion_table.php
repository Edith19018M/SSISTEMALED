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
        Schema::create('formularios_inscripcion', function (Blueprint $table) {
            $table->id('id_formulario');
            $table->unsignedBigInteger('id_emprendimiento');
            $table->dateTime('fecha_envio');
            $table->json('datos_json')->nullable();
            $table->timestamps();
            
            $table->foreign('id_emprendimiento')->references('id_emprendimiento')->on('emprendimientos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formularios_inscripcion');
    }
};
