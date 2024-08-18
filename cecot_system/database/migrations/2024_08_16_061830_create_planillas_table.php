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
            $table->unsignedBigInteger('id_empleado');
            $table->foreign('id_empleado')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        
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
