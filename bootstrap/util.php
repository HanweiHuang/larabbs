<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * for customized daily log
 */
if (!function_exists('laraLog')) {
    function laraLog($data, $path=null)
    {
        if(!$path){
            $path = "/logs/job/error.log";
        }else{
            $path = "/log/job/".$path;
        }
        $monolog = Log::getMonolog();
        $monolog->popHandler();
        Log::info(storage_path().$path, 30 );
        Log::info('single-log: '. $data);
    }
}

/**
 * fro transfer
 */
if(!function_exists('T')){
    function T($code, $lang='en'){

    }
}