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
        Schema::create('visitas', function (Blueprint $table) {
            $table->id('id_visita');  
            $table->string('nombreDelVisitante');
            $table->string('relacionConElPreso');
            $table->date('fechaDeVisita');
            $table->time('horaDeVisita');
            $table->unsignedBigInteger('id_preso');  
            $table->foreign('id_preso')->references('id_preso')->on('presos')->onDelete('cascade');
            $table->timestamps();
        });
           
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};
