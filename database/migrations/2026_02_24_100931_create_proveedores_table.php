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

            $table->integer("tipo_proveedor_id")->nullable();
            $table->integer("giro_id")->nullable();

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
