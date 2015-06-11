<?php

namespace HRis;

use Illuminate\Support\Facades\Lang;

/**
 * Class Translate
 * @package HRis
 */
class Translate
{

    /**
     * @param $text
     * @return mixed
     */
    public static function error($text)
    {
        $slug = $error_message = str_replace(' ', '_', strtolower($text));

        preg_match('/\[.*\]/', $text, $attribute);

        if (count($attribute) > 0) {
            $error_message = str_replace('__', '_', str_replace($attribute[0], '', $slug));
        }

        $translated_text = $final_text = Lang::get('errors.' . $error_message);

        if (count($attribute) > 0) {
            $final_text = str_replace('[:attribute]', $attribute[0], $translated_text);
        }

        return $final_text;
    }
}