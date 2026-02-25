<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('placa')->nullable();
            $table->string('chofer_id')->nullable();
            $table->string('no_economico')->nullable();   
            $table->integer('modelo')->nullable();  
            $table->integer('kilometraje')->nullable();  
            $table->integer('marca_id')->nullable();  
            $table->integer('linea_id')->nullable(); 
            $table->integer('color_id')->nullable(); 
            $table->integer('tipo_vehiculo_id')->nullable();  
            $table->string('numero_serie')->nullable();  
            $table->integer('sucursal_id')->nullable(); 
            $table->integer('area_id')->nullable(); 
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
        Schema::dropIfExists('vehiculos');
    }
}
