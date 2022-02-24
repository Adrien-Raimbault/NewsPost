<?php

class Log
{
    public static $path = "./logs/";

    public static function write($error)
    {
        self::$path .= date('Ymd_',($_SERVER["REQUEST_TIME"]));
        self::$path .= 'log.txt';
        $fichier = fopen(self::$path, 'a+b');
        fwrite($fichier, date("\n".'H:i:s - ',($_SERVER["REQUEST_TIME"])) . $error);
        fclose($fichier);
    }
}
