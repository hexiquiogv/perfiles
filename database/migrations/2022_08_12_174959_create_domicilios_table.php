<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomiciliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domicilios', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('calle')->nullable();
            $table->string('numero_interior')->nullable();
            $table->string('numero_exterior')->nullable();
            $table->string('colonia')->nullable();
            $table->integer('poblacion_id')->nullable();
            $table->integer('municipio_id')->nullable();
            $table->integer('estado_id')->nullable();
            $table->integer('pais_id');
            $table->string('codigo_postal')->nullable();
            $table->string('entre_calles')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();

            $table->integer('domicilioable_id');
            $table->string('domicilioable_type');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domicilios');
    }
}
