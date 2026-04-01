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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 100);
            $table->string('correo', 100)->unique();
            $table->string('contraseña', 255);
            $table->unsignedBigInteger('rol_id');
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->timestamps();
            
            $table->foreign('rol_id')->references('id_rol')->on('roles')->onDelete('restrict');
            $table->foreign('region_id')->references('id_region')->on('regiones')->onDelete('set null');
            $table->foreign('municipio_id')->references('id_municipio')->on('municipios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
