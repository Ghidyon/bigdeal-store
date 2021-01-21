<?php
require_once('app.php');

// A condition to check the path on the url and trim it into an array.
$url = isset( $_SERVER['PATH_INFO'] ) ? explode('/', ltrim( $_SERVER['PATH_INFO'], '/') ) : [];

if (empty($url[0])) {
    $url[0] = 'home'; // When the url array is empty, it adds a default filename
}

// Checks if the filename exists and then adds '.php' extension to it 
// if the filename doesn't exist, the page redirects to 404 error page
if (file_exists( $url[0] . '.php' )) {
    require_once( $url[0] . '.php' );
} else {
    require_once('file_not_found.php');
}