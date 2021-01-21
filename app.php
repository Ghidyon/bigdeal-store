<?php

    // Directory Navigation
    session_start(); // Start user session
    define('APP_ROOT', dirname(__FILE__)); // full directory path for the files
    define('DS', DIRECTORY_SEPARATOR); // for a default seperator in the user environment
    
    // Database Connection
    define('HOST', '127.0.0.1'); // server_name
    define('USERNAME', 'root');
    define('PASSWORD', '');
    define('DBNAME', 'hiapp_user_data');
    
    // folder handle
    define('SITE_NAME', 'Big Deal - Multi-purpose E-commerce Store');
    define('ROOT', '/store/'); // change to '/' when online
    
    // getting scripts for functionality
    require_once(APP_ROOT . DS . 'DBCON.php'); // database connection page
    require_once(APP_ROOT . DS . 'actions' . DS . 'functions.php');
?>