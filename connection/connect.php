<?php

//main connection file for both admin & front end
$servername = "localhost"; //server
$username = "root"; //username
$password = ""; //password
$dbname = "drop";  //database

// Create connection
$db = mysqli_connect($servername, $username, $password, $dbname); // connecting 
$CN=$db;
if (!$db) {       //checking connection to DB	
    die("Connection failed: " . mysqli_connect_error());
}

?>