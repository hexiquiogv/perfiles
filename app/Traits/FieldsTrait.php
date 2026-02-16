<?php

namespace App\Traits;

use DB;
// use Log;

trait FieldsTrait {
    
    public function getFieldsAttribute(){
        $fields_to_exclude = ['uuid','created_at','updated_at','deleted_at'];
        $results=[];
        $sql_statement = "describe " . $this->vista;
        $db_connection = $this->origen->name;
        if ( $db_connection != 'mysql' ) $sql_statement = 
            "select name as Field from sys.columns where object_id = OBJECT_ID('" . $this->vista . "')";

        $columns = DB::connection( $db_connection )->select( $sql_statement );
        for($i=0;$i<count($columns);$i++){
            // Log::info($columns[$i]->Field);
            if (!in_array($columns[$i]->Field, $fields_to_exclude)){
                $results[] = $columns[$i];
            }    
        }
        return $results;
    }

    // public function getFieldsAttribute(){
    //     return $this->schema;
    // }

    // public function getIsNotNewAttribute(){
    //     return $this->id > 0;
    // }
}