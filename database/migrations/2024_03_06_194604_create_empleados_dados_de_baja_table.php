<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('empleados_dados_de_baja', function (Blueprint $table) {
            $table->id();
            $table->string('NumNomina');
            $table->string('Nombre');
            $table->string('ApePat');
            $table->string('ApeMat');
            $table->string('NumSeguridad');
            $table->string('Rfc');
            $table->string('area_id');
            $table->date('FechaIngreso');
            $table->date('fecha_baja');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados_dados_de_baja');
    }
};
