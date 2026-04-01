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
        Schema::create('emprendimientos', function (Blueprint $table) {
            $table->id('id_emprendimiento');
            $table->string('nombre', 255);
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('municipio_id');
            $table->string('estado_proceso', 100)->default('pendiente');
            $table->string('direccion', 255)->nullable();
            $table->string('sector_rubro', 100)->nullable();
            $table->timestamps();
            
            $table->foreign('categoria_id')->references('id_categoria')->on('categorias_emprendimiento')->onDelete('restrict');
            $table->foreign('municipio_id')->references('id_municipio')->on('municipios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprendimientos');
    }
};
