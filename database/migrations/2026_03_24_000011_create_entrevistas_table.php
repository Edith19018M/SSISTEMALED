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
        Schema::create('entrevistas', function (Blueprint $table) {
            $table->id('id_entrevista');
            $table->unsignedBigInteger('id_emprendimiento');
            $table->dateTime('fecha');
            $table->string('evaluador', 255)->nullable();
            $table->string('resultado', 100)->nullable();
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
        Schema::dropIfExists('entrevistas');
    }
};
