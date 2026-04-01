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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('id_venta');
            $table->unsignedBigInteger('id_unidad');
            $table->dateTime('fecha');
            $table->string('producto', 255);
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->timestamps();
            
            $table->foreign('id_unidad')->references('id_unidad')->on('unidades_productivas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
