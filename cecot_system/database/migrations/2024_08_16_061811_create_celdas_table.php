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
        Schema::create('celdas', function (Blueprint $table) {
            $table->id('id_celda');  // Llave primaria
            $table->integer('numeroCelda')->unique();  // Número de la celda único
            $table->boolean('estado');  // Estado de la celda (activo/inactivo)
            $table->integer('capacidad');  // Capacidad máxima de la celda
            $table->integer('numeroDePresos')->default(0);  // Número actual de presos, por defecto 0
            $table->timestamps();  // Timestamps de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celdas');
    }
};


