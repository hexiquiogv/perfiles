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
        DB::statement("insert into catalogos (id,parent_id,name) select id,parent_id,name from poblaciones");

        $items = [
            Catalogo::ESTATUS_MANTENIMIENTO,
            Catalogo::MANTENIMIENTOS,
            Catalogo::ESTATUS_PERSONA,
            Catalogo::MARCA,
            Catalogo::TIPO_VEHICULO,
            Catalogo::TIPO_SANGRE,
            Catalogo::GIRO_PROVEEDOR,
            Catalogo::ESTATUS,
            Catalogo::SEXO,
            Catalogo::SI_NO,
            Catalogo::ORIGEN_INFORMACION,
            Catalogo::STATUS_REPORT,
            Catalogo::ESTADO_CIVIL,
            Catalogo::EMPRESA,
            Catalogo::PUESTO,
            Catalogo::DOCUMENT_TYPE
        ];
        self::store_data($items, null);

        $items = [
            Catalogo::FIRMA,
            Catalogo::REPORTE
        ];
        self::store_data($items, Catalogo::DOCUMENT_TYPE);

        $items = [
            Catalogo::REPROGRAMADO,
            Catalogo::PROGRAMADO,
            Catalogo::EN_PROCESO,
            Catalogo::EN_TALLER,
            Catalogo::CANCELADO,
            Catalogo::GARANTIA,
            Catalogo::AUTORIZADO,
            Catalogo::PENDIENTE_AUTORIZAR,
        ];
        self::store_data($items, Catalogo::ESTATUS_MANTENIMIENTO);

        $items = [
            Catalogo::PREVENTIVO_5000KM,
            Catalogo::PREVENTIVO_10000KM,
            Catalogo::TRANSMISION,
            Catalogo::SUSPENCION,
            Catalogo::ELECTRICO,
            Catalogo::MOTOR,
            Catalogo::ENDERAZO_Y_PINTURA,
            Catalogo::DIRECCION,
            Catalogo::ALINEACION,
            Catalogo::BALANCEO,
            Catalogo::VULCANIZACION,
            Catalogo::LLANTAS,
        ];
        self::store_data($items, Catalogo::MANTENIMIENTOS);

        $items = [
            'A+',
            'A-',
            'B+',
            'B-',
            'AB+',
            'AB-',
            'O+',
            'O-'
        ];
        self::store_data($items, Catalogo::TIPO_SANGRE);

        $items = [
            'HOMBRE',
            'MUJER'
        ];
        self::store_data($items, Catalogo::SEXO);

        $items = [
            'MONTACARGA',
            'SEDAN',
            'CAMIONETA',
            'CAMION',
            'TRACTOR',
            'SUV',
            'REMOLQUE'
        ];
        self::store_data($items, Catalogo::TIPO_VEHICULO);

        $items = [
            'VOLKSWAGEN', 
            'DODGE', 
            'RENAULT', 
            'MAZDA', 
            'TOYOTA', 
            'PORCHE', 
            'GMC', 
            'RANGE ROVER', 
            'FORD', 
            'NISSAN', 
            'FREIGHTLINER', 
            'RAM', 
            'CHEVROLET', 
            'MITSUBISHI', 
            'CATERPILLAR', 
            'COMBILIFT', 
            'KAMATSU', 
            'JETTA', 
        ];
        self::store_data($items, Catalogo::MARCA);

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
            'automotriz',
            'contrucción',
            'papelería',
            'articulos de oficina',
            'sistemas y tecnologías de información',
            'telefonia',
        ];
        self::store_data($items, Catalogo::GIRO_PROVEEDOR);

        $items = [
            "ALVIREGIO",
            "AVA",
            "CASC",
            "DASC",
            "PHS" ,
            "SOS",
        ];
        self::store_data($items, Catalogo::EMPRESA);
        $catalogo = Catalogo::whereNull('parent_id')->where('name',Catalogo::EMPRESA)->first();
        $empresa = Catalogo::where('parent_id',$catalogo->id)->first();

        $items = [
            'MATRIZ',
            'GUAYULERA',
            'PERIFERICO',
            'RAMOS ARIZPE',
            'MORELOS',
            'MADERO',
            'VITO ALESIO'
        ];
        self::store_data($items, $empresa->id);

        $items = [
            'activo',
            'inactivo',
        ];
        self::store_data($items, Catalogo::STATUS_REPORT);

        $items = [
            'mysql'
        ];
        self::store_data($items, Catalogo::ORIGEN_INFORMACION);

        $items = [
            "DIRECCION GENERAL",                 
            "DIRECCION COMERCIAL",               
            "DIRECCION ADMINISTRATIVA",          
            "CHOFER",                            
            "ENCARGADO DE TRASPASOS",            
            "VELADOR",                           
            "CONTRALOR",                         
            "AUDITORIA OPERATIVA",               
            "ADMINISTRACION",                    
            "CREDITO Y COBRANZA",                
            "AUXILIAR DE TRASPASOS",             
            "SUPERVISOR DIV. ACERO",             
            "AUXILIAR DIVISION ACERO",           
            "PROGRAMACION",                      
            "ARCHIVO GENERAL",                   
            "EMPLEADO",                          
            "ENCARGADO",                         
            "SUPERVISOR DIV. TEMPLADO",          
            "SUPERVISOR DE AREA OPERATIVA",      
            "GERENTE DE PLANTA",                 
            "CHOFER DE REPARTO",                 
            "AUXILIAR DE CREDITO Y COBRANZA",    
            "RECURSOS MATERIALES EDIFICIOS",     
            "CONTADOR P.F.",                     
            "CHOFER/AUXILIAR GENERAL",           
            "CAJERA/FACTURISTA",                 
            "RECURSOS HUMANOS",                  
            "CONTADOR ALUMINIOS",                
            "RECURSOS MATERIALES EQ. TRANSPORTE",
            "LIMPIEZA",                          
            "AUXILIAR DE PROYECTOS",             
            "ENCARGADO DE PROYECTOS",            
            "ENCARGADO DE SUCURSAL",             
            "INVENTARIOS",                       
            "INVENTARIOS MATERIALES",            
            "INVENTARIOS HERRAJES",              
            "ALMACENISTA DE HERRAJES",           
            "ENCARGADO DE PATIO",                
            "VENDEDOR DE CAMPO",                 
            "AUXILIAR DE ALMACEN",               
            "ENCARGADO PATIO MAT. PESADO",       
            "AUXILIAR MONTACARGAS",              
            "TRAFICO Y LOGISTICA",               
            "MONTACARGUISTA",                    
            "COMODIN VENTAS",                    
            "ENCARGADO DE ALMACEN MATERIALES",   
            "COORDINADOR SECTOR PONIENTE",       
            "CHOFER FORANEO",                    
            "GERENTE DE VENTAS",                 
            "AUXILIAR DE ALMACEN MAT. PESADO",   
            "MONTACARGUISTA SUCURSAL",           
            "ENCARGADO BASCULA CLIENTES",        
            "CONTADOR GENERAL",                  
            "COMPRAS",                           
            "ENCARGADO BASCULA EMB.",            
            "AUXILIAR CONTABLE",                 
            "TRAFICO Y LOGISTICA TRASPASOS",     
            "CHOFER DE TRASPASOS",               
            "ADMINISTRATIVO DE TRASPASOS",       
            "CAJERA",                            
            "FACTURISTA",                        
            "RECEPCIONISTA",                     
            "INTENDENCIA", 
        ];
        self::store_data($items, Catalogo::PUESTO);

    }

    function store_data($items, $catalogo_name = null, $delete = FALSE) {
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
