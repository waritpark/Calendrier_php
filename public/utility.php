<?php

function e404() {
    require '404.php';
    exit();
}

function debug(...$vars) {
    foreach($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}

function render(string $view, $parameters = []) {
    extract($parameters);
    require ''.$view.'';
}

function h(?string $value): string {
    if ($value == null) {
        return '';
    }
    return htmlentities($value);
}

?>