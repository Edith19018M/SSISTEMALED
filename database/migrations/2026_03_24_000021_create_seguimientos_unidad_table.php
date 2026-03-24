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
        Schema::create('seguimientos_unidad', function (Blueprint $table) {
            $table->id('id_seguimiento');
            $table->unsignedBigInteger('id_unidad');
            $table->integer('numero_seguimiento');
            $table->dateTime('fecha');
            $table->timestamps();
            
            $table->foreign('id_unidad')->references('id_unidad')->on('unidades_productivas')->onDelete('cascade');
            $table->unique(['id_unidad', 'numero_seguimiento'], 'seg_uni_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimientos_unidad');
    }
};
