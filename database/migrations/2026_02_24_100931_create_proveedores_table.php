<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('uuid');
            $table->string('rfc')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('nombre_corto')->nullable();

            // $table->string('calle')->nullable();
            // $table->string('numero_interior')->nullable();
            // $table->string('numero_exterior')->nullable();
            // $table->string('colonia')->nullable();
            // $table->integer('poblacion_id')->nullable();
            // $table->integer('municipio_id')->nullable();
            // $table->integer('estado_id')->nullable();
            // $table->integer('pais_id');
            // $table->string('codigo_postal')->nullable();
            // $table->string('entre_calles')->nullable();
            
            // $table->string('latitud')->nullable();
            // $table->string('longitud')->nullable();

            $table->integer("tipo_proveedor_id")->nullable();
            $table->integer("giro_id")->nullable();

            // $table->dropColumn("email");
            // $table->dropColumn("primer_apellido");
            // $table->dropColumn("segundo_apellido");
            // $table->dropColumn("nombre");
            // $table->dropColumn("telefono");

            $table->text('servicios')->nullable();

            $table->integer('status_id');
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
        Schema::dropIfExists('proveedores');
    }
}
