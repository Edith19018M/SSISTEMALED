<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('emprendedor_id')->nullable()->after('municipio_id');
            $table->foreign('emprendedor_id')
                  ->references('id_emprendedor')
                  ->on('emprendedores')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign(['emprendedor_id']);
            $table->dropColumn('emprendedor_id');
        });
    }
};
