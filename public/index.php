<?php
    define('ROOT_CSS', str_replace("index.php", "", $_SERVER['PHP_SELF']));
    define('ROOT_LINK', str_replace("public/index.php", "", $_SERVER['PHP_SELF']));
    define('ROOT', str_replace("public/index.php", "", $_SERVER['SCRIPT_FILENAME']));
    
    require_once ROOT .'mvc/Bridge.php';
    
    session_start();
    $app = new App;
?>