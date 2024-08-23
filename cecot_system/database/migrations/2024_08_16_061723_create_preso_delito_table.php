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
        Schema::create('preso_delito', function (Blueprint $table) {
            $table->id();  
            $table->unsignedBigInteger('id_preso');
            $table->unsignedBigInteger('id_delito');
            $table->foreign('id_preso')->references('id_preso')->on('presos')->onDelete('cascade');
            $table->foreign('id_delito')->references('id_delito')->on('delitos')->onDelete('cascade');
            $table->timestamps();
        });
        
         
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preso_delito');
    }
};
