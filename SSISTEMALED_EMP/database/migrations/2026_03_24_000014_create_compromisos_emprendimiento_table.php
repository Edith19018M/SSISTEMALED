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
        Schema::create('compromisos_emprendimiento', function (Blueprint $table) {
            $table->id('id_compromiso');
            $table->unsignedBigInteger('id_seguimiento');
            $table->text('descripcion');
            $table->string('estado', 100)->default('pendiente');
            $table->timestamps();
            
            $table->foreign('id_seguimiento')->references('id_seguimiento')->on('seguimientos_emprendimiento')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compromisos_emprendimiento');
    }
};
