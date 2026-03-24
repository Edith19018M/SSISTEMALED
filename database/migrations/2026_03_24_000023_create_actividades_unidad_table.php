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
        Schema::create('actividades_unidad', function (Blueprint $table) {
            $table->id('id_actividad');
            $table->unsignedBigInteger('id_seguimiento');
            $table->text('descripcion');
            $table->string('estado', 100)->default('pendiente');
            $table->unsignedBigInteger('id_compromiso_origen')->nullable();
            $table->timestamps();
            
            $table->foreign('id_seguimiento')->references('id_seguimiento')->on('seguimientos_unidad')->onDelete('cascade');
            $table->foreign('id_compromiso_origen')->references('id_compromiso')->on('compromisos_unidad')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades_unidad');
    }
};
