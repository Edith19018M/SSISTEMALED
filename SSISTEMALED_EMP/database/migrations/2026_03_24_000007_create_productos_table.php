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
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->unsignedBigInteger('id_emprendimiento');
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->decimal('precio_referencial', 10, 2)->nullable();
            $table->json('atributos')->nullable();
            $table->timestamps();
            
            $table->foreign('id_emprendimiento')->references('id_emprendimiento')->on('emprendimientos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
