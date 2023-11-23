<?php

namespace QI\SistemaDeChamados\Controller;

class Logger
{
    private function __construct()
    {
    }

    public static function writeLog($log)
    {
        $log_path = dirname(dirname(__DIR__)) . "/logs/" . date("Y-m-d H-m-s") . ".log";
        $file = fopen($log_path, 'w');
        fwrite($file, $log);
        fclose($file);
    }
}
