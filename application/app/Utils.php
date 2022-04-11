<?php

namespace App;

class Utils
{
    static public function DateTimeCreateFromFormatStrict(string $format, string $dateString)
    {
        $d = \DateTime::createFromFormat($format, $dateString);
        $errors = \DateTime::getLastErrors();
        if ($d && $errors['warning_count'] == 0 && $errors['error_count'] == 0) {
            return $d;
        }
        return false;
    }

    static public function encodeId($data) : string
    {
        return self::urlsafe_base64_encode(json_encode($data));
    }

    static public function decodeId(string $encodedData)
    {
        return json_decode(self::urlsafe_base64_decode($encodedData), true);
    }

    static public function urlsafe_base64_encode($data, $use_padding = false)
    {
        $encoded = strtr(base64_encode($data), '+/', '-_');
        return true === $use_padding ? $encoded : rtrim($encoded, '=');
    }

    static public function urlsafe_base64_decode($data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    static public function encodewith_small_parameters($data){
        $small_data = [];
        foreach($data as $key => $val){
            switch ($key) {
                case 'type': {
                    $small_data['t'] = $val;
                    break;
                }
                case 'student_id': {
                    $small_data['s'] = $val;
                    break;
                }
                case 'id': {
                    $small_data['i'] = $val;
                    break;
                }
                default: {
                    break;
                }
            }
        }
        return self::encodeId($small_data);
    }

    static public function decodewith_long_parameters($data){
        $small_data = self::decodeId($data);
        if(empty($small_data))
            return [];
        foreach($small_data as $key => $val){
            switch ($key) {
                case 't': {
                    $long_data['type'] = $val;
                    break;
                }
                case 's': {
                    $long_data['student_id'] = $val;
                    break;
                }
                case 'i': {
                    $long_data['id'] = $val;
                    break;
                }
                default: {
                    break;
                }
            }
        }

        return $long_data;
    }

}
