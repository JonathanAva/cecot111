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
        Schema::create('planillas', function (Blueprint $table) {
            $table->id('id_planilla');
            $table->unsignedBigInteger('id_usuario'); // Cambiar id_empleado a id_usuario
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade'); // Cambiar clave foránea

            $table->string('turnos_Asignados');
            $table->date('fechas_turno');
            $table->text('actividades_asignadas');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planillas');
    }
};
