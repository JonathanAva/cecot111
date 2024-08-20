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
            $table->id('id_celda');  
            $table->integer('numeroCelda');
            $table->boolean('estado');
            $table->integer('capacidad');
            $table->integer('numeroDePresos')->default(0); // Agregando default 0
            $table->timestamps();
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

