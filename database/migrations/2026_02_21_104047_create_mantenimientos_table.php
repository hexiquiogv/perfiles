<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantenimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('vehiculo_id');
            $table->string('chofer_id')->nullable();
            $table->date('fecha_reporte')->nullable();
            $table->date('fecha_revisado')->nullable();
            $table->date('fecha_autorizado')->nullable();
            $table->date('programado_para_ingreso')->nullable();
            $table->date('fecha_ingresado')->nullable();
            $table->date('fecha_entregado')->nullable();
            $table->string('taller_id')->nullable();

            $table->integer('estatus_id')->nullable(); 

            $table->integer('user_id')->nullable();
            $table->text('observaciones')->nullable();    

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mantenimientos');
    }
}
