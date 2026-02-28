<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstalacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instalaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id');
            $table->string('nombre');
            $table->integer('contacto_id')->nullable();
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
            $table->string('telefono')->nullable();
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
        Schema::dropIfExists('instalaciones');
    }
}
