<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Mantenimiento;
use App\Models\Vehiculo;
use App\Models\Instalacion;
use App\Models\Catalogo;
use App\Models\Media;

use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Helpers\CodeGenerator;
use Auth;
use Cezpdf;
use Lang;

class OrdenController extends Controller
{
    public function index()
    {
        return view('ordenes.index');
    }

    public function edit($uuid)
    {
        $registro = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($registro)) dd("Orden no encontrada");

        $route = route('ordenes.update',$registro->uuid);
        $method = "patch";
        $title = "Orden de Mantenimiento - Edición de Registro";
        $back_url = route('ordenes.edit',$registro->uuid);

        return view('ordenes.form', 
                    compact('registro','title','route','method','back_url'));
    }

    public function update(Request $request, $uuid)
    {
        $mantenimiento = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($mantenimiento)) dd("Reporte no encontrado");

        $oldReporte = $mantenimiento->replicate();
        $oldReporte->created_at = now();
        $oldReporte->save();
        $oldReporte->delete();

        $mantenimiento = self::persist_data($request, $mantenimiento);

        return redirect()->route("ordenes.edit",$mantenimiento->uuid)
                    ->withSuccess("Orden {$mantenimiento->folio} actualizado exitosamente");
    }

    private function persist_data(Request $request, Mantenimiento $mantenimiento){        
        $mantenimiento->fecha_reporte_revisado = now();        
        $mantenimiento->programado_para_ingreso = $request->programado_para_ingreso ?? null;

        // todo : consolidar tipo de servicios por checkboxes
        $mantenimiento->servicios = $request->servicios ?? null;
        $mantenimiento->diagnostico = $request->diagnostico ?? null;

        $servicios = isset($request->servicios) ? implode(',',$request->servicios) : "";
        $mantenimiento->servicios = $servicios;
        
        $mantenimiento->user_id = Auth::id();
        $mantenimiento->save();

        return $mantenimiento;
    }

    public function orden($uuid){        
        $registro = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($registro)) dd("Reporte no encontrado");

        $variables = [
            "<unidad>" => $registro->vehiculo->numero_economico,
            "<tipo_vehiculo>" => $registro->vehiculo->tipo_vehiculo->name,
            "<marca>" => strtoupper($registro->vehiculo->marca->name),
            "<linea>" => strtoupper($registro->vehiculo->linea->name),
            "<modelo>" => $registro->vehiculo->modelo,
            "<serie>" => strtoupper($registro->vehiculo->numero_serie),
            "<placas>" => strtoupper($registro->vehiculo->placa),
            "<chofer>" => strtoupper($registro->vehiculo->chofer->fullname),
            "<falla>" => $registro->descripcion_falla,
            "<empresa>" => strtoupper($registro->empresa->name),
        ];

        setlocale(LC_ALL, 'es_ES');
        $fecha=$registro->updated_at->translatedFormat('l j \\d\\e F \\d\\e Y');
        
        $pdf = new Cezpdf($paper = 'A4', $orientation = 'portrait'); // $orientation = 'landscape';
        
        $pdf->ezSetMargins($top = 30, $bottom = 30, $left = 30, $right = 30);
        $pdf->ezSetDy(0, 'makeSpace');

        $logo = "images/logos/transparente.png";
        $pdf->addPngFromFile($logo, 25, 730, 90, 75);

        $pdf->ezSetDy(-80, 'makeSpace');   
        $pdf->ezText("FECHA : $fecha",10, array('justification' => 'right'));
                 
        $y = $pdf->y;
        $y = $y - 20;
        $pdf->addText(30,$y,12,"CHOFER");        
        $pdf->addText(90,$y,10,$variables["<chofer>"]);

        $y = $y - 20;
        $pdf->addText(30,$y,12,"UNIDAD");        
        $pdf->addText(130,$y,10,$variables["<unidad>"]);
        $pdf->addText(200,$y,12,"MARCA");        
        $pdf->addText(255,$y,10,$variables["<marca>"]);
        $pdf->addText(340,$y,12,"MODELO");        
        $pdf->addText(400,$y,10,$variables["<modelo>"]);

        $y = $y - 20;
        $pdf->addText(30,$y,12,"NUMERO DE SERIE");        
        $pdf->addText(150,$y,10,$variables["<serie>"]);
        $pdf->addText(360,$y,12,"PLACAS");        
        $pdf->addText(415,$y,10,$variables["<placas>"]);


        $pdf->y = $y - 20;
        $pdf->ezText("DESCRIPCION DETALLADA DE FALLA MECANICA" , 12, array('justification' => 'center')); 
        $pdf->ezSetDy(-20, 'makeSpace');     
        $pdf->ezText($variables["<falla>"] , 10, array('justification' => 'full'));   
        $pdf->ezSetDy(-20, 'makeSpace'); 

        // $pdf->line(30, $y, ,$pdf->y);
        $pdf->setLineStyle(1);
        $pdf->rectangle($pdf->ez['leftMargin'] - 10, $y-20, 
                        $pdf->ez['pageWidth'] - $pdf->ez['rightMargin'] - $pdf->ez['leftMargin'] + 20, 
                        $pdf->y - $y + 10);
        
        $pdf->ezSetDy(-20, 'makeSpace');   
        $pdf->ezText("FIRMA DE CHOFER",12,array('justification'=>'center'));

        $firma = 'storage/'.$registro->firmaChofer->url;
        $pdf->addPngFromFile($firma, 230, 460, 140, 75);

        $pdf->ezSetDy(-45, 'makeSpace');   
        $pdf->ezText("<strong>".str_repeat("_",strlen($variables["<chofer>"]))."</strong>",12,
            array('justification'=>'center'));
        $pdf->ezText("<strong>".$variables["<chofer>"]."</strong>",12,array('justification'=>'center'));

        //$pdf->addText(360,290,12,"FIRMA DE CHOFER");   
        //$pdf->addText(88,80,12,"<strong>".$variables["<chofer>"]."</strong>");   

        $qr = CodeGenerator::qrcodeGenerate(route('mantenimientos.edit',$registro->uuid));
        Storage::disk('public')->put('qr.png',base64_decode($qr));

        $pdf->addPngFromFile("storage/qr.png",400,100,100);
        $pdf->addText(400,85,8,"EMPRESA : ".$variables["<empresa>"]);

        if (ob_get_contents()) ob_end_clean();

        // Se graba el pdf en el sistema de archivos
        $filename = "{$uuid}.pdf";
        $disk = env('FILESYSTEM_DRIVER','local');
        Storage::disk($disk)->put($filename, $pdf->Output());

        $documento_type = Catalogo::find_item(Catalogo::DOCUMENT_TYPE,Catalogo::REPORTE)->first();

        $model_name = get_class($registro);
        $model_id = $registro->id;
        Media::where('model_name',$model_name)->where('model_id',$model_id)
                    ->where('document_type_id',$documento_type->id)
                    ->delete(); 

        $media = new Media;
        $media->extension = "pdf";
        $media->url = $filename;
        $media->uuid = (string)Str::orderedUuid(); 
        $media->mime_type = "application/pdf";
        $media->model_name = $model_name;
        $media->model_id = $model_id;
        $media->document_type_id = $documento_type->id;
        $media->save();

        // envio mensaje a telegram
        $reporte = Lang::get("telegram.reporte_falla");        
        $mensaje = strtr($reporte, $variables);        

        // $channel_id = env('TELEGRAM_CHANNEL_ID', '');
        // Telegram::sendMessage([
        //     'chat_id' => $channel_id,
        //     'parse_mode' => 'HTML',
        //     'text' => $mensaje
        // ]);

        // cambio de estatus
        $estatus = Catalogo::find_item(Catalogo::ESTATUS_MANTENIMIENTO,Catalogo::ORDEN_SERVICIO)->first();
        $registro->estatus_id = $estatus->id;
        $registro->save();
        
        return response()->file("storage/$filename");
    }
}

