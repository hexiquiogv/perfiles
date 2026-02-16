<?php

$data = $img = $_POST['imgData'];

// elimina informacion que no es utilizada
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);

// una vez que se elimina la informacion se decodifica
$data = base64_decode($img);

// crea el folder donde se almacenaran las imagenes
$folder = "img/upload/";
$path = dirname(__FILE__) . '/../../../'. $folder;

// construye el nombre de la imagen a guardar en el file system
$filename = 'tmp.png';

// graba el archivo en el fileSystem
file_put_contents($path . $filename, $data);

echo $folder.$filename;
