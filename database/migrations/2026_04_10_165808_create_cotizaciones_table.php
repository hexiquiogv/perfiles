<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('model_name')->nullable();
            $table->string('model_id')->nullable();
            $table->integer('proveedor_id')->nullable();
            $table->double('monto')->nullable();
            $table->text('comentarios')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('seleccionada_id')->nullable();
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
        Schema::dropIfExists('cotizaciones');
    }
}
