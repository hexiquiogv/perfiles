<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class CustomModel extends Model {
    // use SoftDeletes;

    protected static $_table;
    public $timestamps = false;

    public static function fromTable($table, $parms = Array()){
        $ret = null;
        if (class_exists($table)){
            $ret = new $table($parms);
        } else {
            $ret = new static($parms);
            $ret->setTable($table);
        }
        return $ret;
    }
	
    public function setTable($table)
    {
        static::$_table = $table;
    }

    public function getTable()
    {
        return static::$_table;
    }    
}
