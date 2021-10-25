<?php

function debug(...$vars) {
    foreach($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '<pre>';
    }
}


?>