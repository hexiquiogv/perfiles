<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Schema;
use DNS1D;
use DNS2D;

class CodeGenerator {
	public static function barcodeGenerate($text){
		return DNS1D::getBarcodePNG($text, 'C39', 1, 133, array(255,0 ,0), true);
	}

	public static function qrcodeGenerate($text){
		return DNS2D::getBarcodePNG($text, 'QRCODE',3,3,array(1,1,1));
	}
}	