<?php
namespace App\Helpers;

class Utilities {
	public static function justifyText($text, $width = 0, $justification = 'left', 
		$character = ' ') {

        $results = "";
        switch ($justification) {
            case "full":
                $words = explode(' ', $text);

                if ($width == 0 || strlen($text) > $width)
                    return $text;

                $number_of_words = count($words) - 1;
                $difference = $width - strlen($text);

                $number_of_characters_to_insert = (floor((($difference + $number_of_words)/ $number_of_words)));
                $number_of_character_extra_to_insert = fmod($difference, $number_of_words);

                $results = "";
                for ($index = 0; $index < count($words); $index++) {
                    $multiplier = ($number_of_words > 0 ? $number_of_characters_to_insert : 0) + ($number_of_character_extra_to_insert > 0 ? 1 : 0);
                    if ($index == count($words) - 1) {
                        $multiplier = 1;
                    }
               
                    $results .= $words[$index] . str_repeat($character, $multiplier);
                    $number_of_character_extra_to_insert--;
                    $number_of_words--;
                }

                break;

            case "right";
                $results = str_pad($text, $width, $character, STR_PAD_RIGHT);
                break;

            case "left";
                $results = str_pad($text, $width, $character, STR_PAD_LEFT);
                break;

            case "center";
                $results = str_pad($text, $width, $character, STR_PAD_BOTH);
                break;

            default:
                $results = $text;
                break;
        }

        return $results;
    }

    public static function date_formated($date=null, $format="d/m/Y", $default=""){
        if (is_null($date)) return $default;
        return $date->format($format);
    }
 }