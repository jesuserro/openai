<?php

namespace Cdr\Utils;

class Output {
    public static function print($message) {
        if (php_sapi_name() == "cli") {
            // Ejecutado en la terminal
            echo $message . PHP_EOL;
        } else {
            // Ejecutado en un navegador
            echo nl2br($message) . "<br />";
        }
    }
}
