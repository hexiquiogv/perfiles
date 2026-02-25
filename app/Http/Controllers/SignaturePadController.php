<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Config;

class SignaturePadController extends Controller
{
    public function index()
    {
        return view('signaturePad.form');
    }
    
    public function upload(Request $request)
    {
        // $folderPath = public_path('upload/');        
        $image_parts = explode(";base64,", $request->signed);
              
        $image_type_aux = explode("image/", $image_parts[0]);
           
        $image_type = $image_type_aux[1];
           
        $image_base64 = base64_decode($image_parts[1]);
        
        $file = uniqid() . '.'.$image_type;
        $folderPath = storage_path('/app/public/'.$file);
        
        file_put_contents($file, $image_base64);
        return back()->with('success', 'success Full upload signature');
    }
}
