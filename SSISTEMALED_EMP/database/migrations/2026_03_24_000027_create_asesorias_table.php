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
        Schema::create('asesorias', function (Blueprint $table) {
            $table->id('id_asesoria');
            $table->unsignedBigInteger('id_emprendimiento');
            $table->dateTime('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('tipo', 100);
            $table->string('tematica', 255);
            $table->text('descripcion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->foreign('id_emprendimiento')->references('id_emprendimiento')->on('emprendimientos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesorias');
    }
};
