<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//         CREATE OR REPLACE VIEW movimientos 
// AS 
// SELECT proyecto, 
//        varBusqueda, 
//        idUsuario, 
//        nombreUsuario, 
//        idProducto, 
//        descProducto, 
//        SUM(cantidad) AS stockmovimientosmovimientos
// FROM century_caja_terminal c
// LEFT JOIN OtraTabla o ON o.idOtraTabla = c.idDelaTablaAnterior
// GROUP BY varBusqueda

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id');
                        
            $table->integer('origen_informacion_id');
            $table->integer('consulta_id');
            $table->string('uuid')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            // $table->string('category_id')->nullable();
            $table->text('columns')->nullable();
            $table->text('criterial_fields')->nullable();

            $table->integer('status_id')->nullable();
            $table->timestamp('fecha_status')->nullable();;

            $table->integer('user_id');
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
        Schema::dropIfExists('reports');
    }
}
