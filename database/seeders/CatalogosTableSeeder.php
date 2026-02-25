<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Catalogo;
use Carbon\Carbon;
use Log;
use DB;

class CatalogosTableSeeder extends Seeder
{
    public function run()
    {
      Catalogo::truncate();
        //DB::statement("insert into catalogos (id,parent_id,name) select id,parent_id,name from poblaciones");

        $items = [
            Catalogo::ESTATUS_MANTENIMIENTO,
            Catalogo::ESTATUS_PERSONA,
            Catalogo::MARCA,
            Catalogo::TIPO_VEHICULO,
            Catalogo::TIPO_PROVEEDOR,
            Catalogo::NOMBRE_PLAN,
            Catalogo::ESTATUS,
            Catalogo::METODO_PAGO,
            Catalogo::TIPO_SEGURO,
            Catalogo::FORMA_PAGO,
            Catalogo::CLASIFICACION_PLAN,
            Catalogo::SEXO,
            Catalogo::SI_NO,
            Catalogo::ORIGEN_INFORMACION,
            Catalogo::STATUS_REPORT,
            Catalogo::ESTADO_CIVIL
        ];
        self::store_data($items, null);

        $items = [
            Catalogo::EN_VIGOR,
            Catalogo::PRORROGADO,
            Catalogo::ANULADA
        ];
        self::store_data($items, Catalogo::ESTATUS_MANTENIMIENTO);

        $items = [
            'HOMBRE',
            'MUJER'
        ];
        self::store_data($items, Catalogo::SEXO);

        $items = [
            'SI',
            'NO'
        ];
        self::store_data($items, Catalogo::SI_NO);

        $items = [
            'CASADO',
            'DIVORCIADO',
            'SOLTERO',
            'VIUDO',
            'UNION LIBRE'
        ];
        self::store_data($items, Catalogo::ESTADO_CIVIL);

        $items = [
            'activo',
            'inactivo',
        ];
        self::store_data($items, Catalogo::STATUS_REPORT);

        $items = [
            'mysql'
        ];
        self::store_data($items, Catalogo::ORIGEN_INFORMACION);
    }

    function store_data($items, $catalogo_name = null, $delete = TRUE) {
        $catalogo = Catalogo::where('name','=',$catalogo_name)->first();
        $parent_id = is_null($catalogo) ? null : $catalogo->id ; 

        if ($delete){
            Catalogo::where('parent_id',$parent_id)->delete();
        }

        $rows = [];
        //$id = 1;
        foreach ($items as $item) {
            $rows[] = [
                //'id' => $id,
                'parent_id' => $parent_id,
                'name' => mb_strtolower($item),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ];
            
            //$id = $id + 1;
        }
        //dd($rows);
        DB::table('catalogos')->insert( $rows );
    }
}
