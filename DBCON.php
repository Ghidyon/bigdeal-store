<?php

// Create connection
//servername, username, password, database_name
$conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

// Check connection 

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error); // When there is an error, run this!
}

return $conn;
?>