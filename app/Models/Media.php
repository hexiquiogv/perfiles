<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;
    
    protected $table = "medias";

    public function document_type() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'document_type_id')
            ->withDefault('name','');
    }
}
