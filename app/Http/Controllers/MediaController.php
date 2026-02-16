<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Media;
use App\Models\Reservacion;
use App\Models\Catalogo;
use Config;
use Auth;

class MediaController extends Controller
{
		public function show(Request $request, $model_name, $model_id)
		{
			// para el nombre del modelo, en lugar de slash utilizar puntos
			$model_name = str_replace(".","\\",$model_name);
			$registro = new $model_name;
			$registro = $registro->find($model_id);
			//dd($registro);
			$disk = Config::get('constants.storage_disk');

			return view('media.show', compact('registro','disk'));
		} 

		public function store(Request $request)
		{
			$this->validate($request, [
	            'uploadFile' => 'required'
	        ]);

			$model = ($request['model_name'])::where('uuid',$request->model_id)->first();
        	if (is_null($model)) dd("Registro no encontrado");        	

			$disk = env('FILESYSTEM_DRIVER','local');
			$file = $request->file('uploadFile');
			$extension = $file->extension();
			$mimeType = $file->getMimeType();
			$filename = "f_".date("YmdHis").".$extension";
			$path = Storage::disk($disk)->putFileAs(".", $file, $filename, 'public');

			$media = new Media;
			$media->extension = $extension;
			$media->url = $path;
			$media->uuid = (string)Str::orderedUuid();   
			$media->mime_type = $mimeType;
			$media->model_name = $request['model_name'];
			$media->model_id = $model->id;
			$media->document_type_id = $request->document_type_id ?? null;
			$media->observations = $_FILES['uploadFile']['name'];
			$media->save();

			if ( strtolower(trim($media->document_type->name)) == "factura (pdf)") {
				$model->factura = $request->factura ?? null;
				$model->monto  = $request->monto ?? 0;

				$catalogo = Catalogo::where('name',Catalogo::ESTATUS)->whereNull('parent_id')->first();        
        		$facturada = Catalogo::where('parent_id',$catalogo->id)->where('name','like',Catalogo::FACTURADA)->first();
        		$model->estatus_id = $facturada->id;

				$model->save();
			}

			return back()->with('info',"El archivo se ha guardado con éxito.");
		} 

		public function delete($uuid)
		{
			$file = Media::where('uuid',$uuid)->first();
        	if (is_null($file)) dd("Registro no encontrado");
        	
			$file->delete();
			
			return back()->with('status','El archivo ha sido eliminado con éxito.');
		}

		public function download($uuid)
		{
			$file = Media::where('uuid',$uuid)->first();
        	if (is_null($file)) dd("Registro no encontrado");

			return response()->file(storage_path('/app/public/' . $file->url, $file->headers));
		}
}
