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
        Schema::create('seguimientos_emprendimiento', function (Blueprint $table) {
            $table->id('id_seguimiento');
            $table->unsignedBigInteger('id_emprendimiento');
            $table->integer('numero_seguimiento');
            $table->dateTime('fecha');
            $table->timestamps();
            
            $table->foreign('id_emprendimiento')->references('id_emprendimiento')->on('emprendimientos')->onDelete('cascade');
            $table->unique(['id_emprendimiento', 'numero_seguimiento'], 'seg_emp_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimientos_emprendimiento');
    }
};
