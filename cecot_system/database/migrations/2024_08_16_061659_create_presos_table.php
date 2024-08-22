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
        Schema::create('presos', function (Blueprint $table) {
            $table->id('id_preso');  // Clave primaria de tipo bigint (por defecto)
            $table->string('nombre');
            $table->string('apellido');
            $table->date('fechaNacimiento');
            $table->string('numeroIdentificacion')->unique();
            $table->date('fechaIngreso');
            $table->date('fechaLiberacion')->nullable();
            $table->boolean('estado');
            $table->string('condena');

            // Agregar la relación con la tabla celdas
            $table->unsignedBigInteger('id_celda');
            $table->foreign('id_celda')->references('id_celda')->on('celdas')->onDelete('cascade');

            $table->timestamps();
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presos');
    }
};
