<?php
use Carbon\Carbon;

//for customized daily log
if (!function_exists('laraLog')) {
    function laraLog($data, $path=null)
    {
        if(!$path){
            $path = "/logs/job/error.log";
        }
        $monolog = Log::getMonolog();
        $monolog->popHandler();
        Log::useDailyFiles(storage_path().$path, 30 );
        Log::info('single-log: '. $data);
    }
}