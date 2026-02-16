<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegurosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguros', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('estatus_id')->nullable();   
            $table->integer('nombre_plan_id')->nullable();   
            $table->string('poliza')->nullable();   
            $table->date('fecha_emision')->nullable();
            $table->date('fecha_terminacion')->nullable();
            $table->integer('metodo_pago_id')->nullable();   
            $table->integer('tipo_seguro_id')->nullable();   
            $table->integer('forma_pago_id')->nullable();  
            $table->integer('clasificacion_plan_id')->nullable();  
            $table->integer('contratante_id')->nullable();  
            $table->integer('asegurado_principal_id')->nullable();   

            $table->double('suma_asegurada')->nullable();
            $table->double('suma_asegurada_convertida')->nullable();
            $table->double('prima_anual')->nullable();
            $table->double('prima_anual_convertida')->nullable();
            $table->double('deducible_convertido')->nullable();
            
            $table->text('comentarios')->nullable();

            $table->integer('user_id');   
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
        Schema::dropIfExists('seguros');
    }
}
