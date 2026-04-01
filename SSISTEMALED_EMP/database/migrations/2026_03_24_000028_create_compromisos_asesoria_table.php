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
        Schema::create('compromisos_asesoria', function (Blueprint $table) {
            $table->id('id_compromiso');
            $table->unsignedBigInteger('id_asesoria');
            $table->string('actividad', 255);
            $table->string('responsable', 255);
            $table->date('fecha');
            $table->string('estado', 100)->default('pendiente');
            $table->timestamps();
            
            $table->foreign('id_asesoria')->references('id_asesoria')->on('asesorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compromisos_asesoria');
    }
};
