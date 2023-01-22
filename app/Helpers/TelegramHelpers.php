<?php

namespace App\Helpers;

use Carbon\Carbon;

class TelegramHelpers
{
    public static function validateInitData($data) : bool
    {
        try {
            $data_check_arr = explode('&', rawurldecode($data));
            $needle = 'hash=';
            $check_hash = FALSE;
            foreach ($data_check_arr as &$val) {
                if (substr($val, 0, strlen($needle)) === $needle) {
                    $check_hash = substr_replace($val, '', 0, strlen($needle));
                    $val = NULL;
                }
            }

            // if( $check_hash === FALSE ) return FALSE;
            $data_check_arr = array_filter($data_check_arr);
            sort($data_check_arr);

            $data_check_string = implode("\n", $data_check_arr);
            $secret_key = hash_hmac('sha256', config('services.telegram.token'), "WebAppData", TRUE);
            $hash = bin2hex(hash_hmac('sha256', $data_check_string, $secret_key, TRUE));

            if (strcmp($hash, $check_hash) === 0 && !self::isExpired($data)){
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function formatInitData($data) : array
    {
        $data_check_arr = explode('&', rawurldecode($data));
        $array = [];
        foreach ($data_check_arr as $val) {
            $val = explode('=', $val);
            $array[$val[0]] = $val[1];
        }
        $array['user'] = json_decode($array['user'], TRUE);
        $array['auth_date'] = Carbon::createFromTimestamp($array['auth_date']);

        return $array;
    }

    public static function isExpired($data) : bool
    {
        $data = self::formatInitData($data);
        $now = Carbon::now();
        $diff = $now->diffInMinutes($data['auth_date']);
        if ($diff > config('services.telegram.init_data_expire_minutes')) {
            return true;
        } else {
            return false;
        }
    }
}
