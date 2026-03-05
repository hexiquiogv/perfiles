<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Persona;
use Illuminate\Support\Str;

class PersonasTableSeeder extends Seeder
{
    public function run()
    {
        $personas = Persona::get();
        foreach ($personas as $persona) {
            if (is_null($persona->uuid) || strlen($persona->uuid) == 0) {
                $persona->uuid = (string)Str::orderedUuid(); 
                $persona->save();
            }
        }
        
    }
}
