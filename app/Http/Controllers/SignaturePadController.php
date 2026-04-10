<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Mantenimiento;
use App\Models\Catalogo;
use App\Models\Media;
use Illuminate\Support\Str; 
use Config;

class SignaturePadController extends Controller
{
    public function index(Request $request)
    {
        $title = "Firma de Chofer (reporte de falla)";
        $model_id = $request->model_id;
        $model_name = $request->model_name;
        $registro = ($model_name)::where('uuid',$model_id)->first();
        if (is_null($registro)) return back()->withError('El registro no encontrado');
        
        $back_url = route('mantenimientos.edit',$registro->uuid);

        return view('signaturePad.form',compact('title','model_id','model_name','back_url'));
        //return view('test.signature_2');
    }
    
    public function upload(Request $request)
    {
        $model_name = $request['model_name'] ?? null;
        $model_id = $request['model_id'] ?? null;
        $back_url = $request['back_url'] ?? null;

        $registro = ($model_name)::where('uuid',$model_id)->first();
        if (is_null($registro)) return back()->withError('El registro no encontrado');

        // $folderPath = public_path('upload/');        
        $image_parts = explode(";base64,", $request->signed);
              
        $image_type_aux = explode("image/", $image_parts[0]);
           
        $image_type = $image_type_aux[1];
           
        $image_base64 = base64_decode($image_parts[1]);
        
        $uuid = (string)Str::orderedUuid(); 
        // $file = uniqid() . '.'.$image_type;
        $filename = $uuid . '.' . $image_type;        

        $folderPath = storage_path('/app/public/'.$filename);
        file_put_contents($folderPath, $image_base64);
        // $disk = env('FILESYSTEM_DRIVER','local');
        // $path = Storage::disk($disk)->putFileAs(".", $image_base64, $filename, 'public');
        
        $documento_type = Catalogo::find_item(Catalogo::DOCUMENT_TYPE,Catalogo::FIRMA)->first();
        
        Media::where('model_name',$model_name)->where('model_id',$registro->id)
                    ->where('document_type_id',$documento_type->id)
                    ->delete(); 

        $media = new Media;
        $media->extension = $image_type;
        $media->url = $filename;
        $media->uuid = $uuid;
        $media->mime_type = $image_type;
        $media->model_name = $model_name;
        $media->model_id = $registro->id;
        $media->document_type_id = $documento_type->id;
        $media->observations = "firma de chofer";
        $media->save();

        return redirect(route("mantenimientos.reporte",$registro->uuid)
                    )->with('success', 'Firma exitosa y generacion de reporte');
    }
}
