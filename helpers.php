<?php
if (!function_exists('dd')) {
    function dd(...$vars) {
        foreach ($vars as $var) {
            echo "<pre>";
            var_dump($var);
            echo "</pre>";
        }
        die();
    }
}
