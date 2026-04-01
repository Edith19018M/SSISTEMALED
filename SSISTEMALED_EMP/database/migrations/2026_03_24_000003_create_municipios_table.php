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
        Schema::create('municipios', function (Blueprint $table) {
            $table->id('id_municipio');
            $table->string('nombre_municipio', 100);
            $table->unsignedBigInteger('id_region');
            $table->timestamps();
            
            $table->foreign('id_region')->references('id_region')->on('regiones')->onDelete('cascade');
            $table->unique(['nombre_municipio', 'id_region']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipios');
    }
};
