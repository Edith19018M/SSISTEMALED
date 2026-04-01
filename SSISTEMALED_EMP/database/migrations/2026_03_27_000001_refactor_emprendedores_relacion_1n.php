<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Eliminar tabla pivot (N:M ya no se usa)
        Schema::dropIfExists('emprendimiento_emprendedor');

        // 2. Modificar tabla emprendedores para relación 1:N
        Schema::table('emprendedores', function (Blueprint $table) {
            // Eliminar restricciones únicas (la misma persona puede registrarse
            // en varios emprendimientos con distinto código)
            $table->dropUnique('emprendedores_ci_unique');
            $table->dropUnique('emprendedores_correo_unique');

            // Nuevo campo: código único por emprendedor
            $table->string('codigo', 50)->unique()->after('id_emprendedor');

            // FK al emprendimiento al que pertenece
            $table->unsignedBigInteger('id_emprendimiento')->nullable()->after('codigo');
            $table->foreign('id_emprendimiento')
                  ->references('id_emprendimiento')
                  ->on('emprendimientos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('emprendedores', function (Blueprint $table) {
            $table->dropForeign(['id_emprendimiento']);
            $table->dropUnique('emprendedores_codigo_unique');
            $table->dropColumn(['codigo', 'id_emprendimiento']);
            $table->unique('ci');
            $table->unique('correo');
        });

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
};
