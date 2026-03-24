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
        Schema::create('emprendimiento_emprendedor', function (Blueprint $table) {
            $table->unsignedBigInteger('id_emprendimiento');
            $table->unsignedBigInteger('id_emprendedor');
            $table->boolean('es_responsable_principal')->default(false);
            $table->timestamps();
            
            $table->primary(['id_emprendimiento', 'id_emprendedor']);
            $table->foreign('id_emprendimiento')->references('id_emprendimiento')->on('emprendimientos')->onDelete('cascade');
            $table->foreign('id_emprendedor')->references('id_emprendedor')->on('emprendedores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprendimiento_emprendedor');
    }
};
