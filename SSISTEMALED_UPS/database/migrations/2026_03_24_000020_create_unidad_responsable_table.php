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
        Schema::create('unidad_responsable', function (Blueprint $table) {
            $table->unsignedBigInteger('id_unidad');
            $table->unsignedBigInteger('id_responsable');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->timestamps();
            
            $table->primary(['id_unidad', 'id_responsable']);
            $table->foreign('id_unidad')->references('id_unidad')->on('unidades_productivas')->onDelete('cascade');
            $table->foreign('id_responsable')->references('id_responsable')->on('responsables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidad_responsable');
    }
};
