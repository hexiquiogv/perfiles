<?php 

namespace App\Helpers;

class String_Util{

  public static function  decamelize($word) {
    return preg_replace(
      '/(^|[a-z])([A-Z])/e', 
      'strtolower(strlen("\\1") ? "\\1_\\2" : "\\2")',
      $word 
    ); 
  }

  public static function camelize($word) { 
    return preg_replace('/(^|_)([a-z])/e', 'strtoupper("\\2")', $word); 
  }

  public static function camel_to_snake($input)
  {
      return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
  }

  public static function snakeToCamel($input)
  {
      return ucwords(lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input)))));
  }

}