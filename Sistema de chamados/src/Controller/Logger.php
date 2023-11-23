<?php

namespace QI\SistemaDeChamados\Controller;

class Logger
{
    private function __construct()
    {
    }

    public static function writeLog($log)
    {
        $logsDir = dirname(dirname(__DIR__)) . "/logs/";
        if (!is_dir($logsDir)) {
            mkdir($logsDir);
        }
        $log_path =  $logsDir . date("Y-m-d h-i-s") . ".log";
        $file = fopen($log_path, 'w');
        fwrite($file, $log);
        fclose($file);
    }
}
