<?php

class Autoloader {

    static public function register($class)
    {
        $path = realpath('.');
        $array2 = explode(chr(92), $class);
        $count2 = count($array2) - 1;
        $class = $array2[$count2].".php";
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename) {
            if (strpos($filename, '.php') !== false) {
                $array = explode("/", $filename);
                $count = count($array) - 1;
                if ($array[$count] == $class)
                    require_once $filename;
            }
        }
    }
}

spl_autoload_register('Autoloader::register');