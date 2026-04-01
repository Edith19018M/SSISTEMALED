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
        Schema::create('emprendedores', function (Blueprint $table) {
            $table->id('id_emprendedor');
            $table->string('nombre', 100);
            $table->string('apellidos', 100);
            $table->integer('edad')->nullable();
            $table->char('sexo', 1)->nullable();
            $table->string('ci', 50)->unique();
            $table->string('celular', 20)->nullable();
            $table->string('correo', 100)->unique();
            $table->string('direccion', 255)->nullable();
            $table->string('carrera', 150)->nullable();
            $table->string('año_estudio', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprendedores');
    }
};
