<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('nombre')->nullable();   
            $table->string('paterno')->nullable();   
            $table->string('materno')->nullable();   
            $table->string('curp')->nullable();   
            $table->string('rfc')->nullable();   
            $table->string('nss')->nullable();  

            $table->date('fecha_nacimiento')->nullable();
            $table->string('email')->nullable();   
            $table->string('telefono')->nullable();   
            $table->integer('sexo_id')->nullable();  
            $table->integer('tipo_sangre_id')->nullable();  

            $table->integer('estado_civil_id')->nullable();  

            $table->integer('user_id')->nullable();
            $table->text('comentarios')->nullable();    

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
        Schema::dropIfExists('personas');
    }
}
