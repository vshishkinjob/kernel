<?php

spl_autoload_register(function ($class_name) {
    if (!is_file(__DIR__ . "/$class_name.php")) {
        return;
    }
    include $class_name . '.php';
});
