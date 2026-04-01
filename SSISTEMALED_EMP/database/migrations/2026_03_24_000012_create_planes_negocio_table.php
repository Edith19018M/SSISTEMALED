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
        Schema::create('planes_negocio', function (Blueprint $table) {
            $table->id('id_plan');
            $table->unsignedBigInteger('id_emprendimiento');
            $table->dateTime('fecha');
            $table->string('documento_url', 255)->nullable();
            $table->boolean('certificado_nacimiento')->default(false);
            $table->timestamps();
            
            $table->foreign('id_emprendimiento')->references('id_emprendimiento')->on('emprendimientos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes_negocio');
    }
};
