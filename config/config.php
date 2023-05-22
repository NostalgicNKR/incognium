<?php
$dbName = "url";
$dbUser = "root";
$dbPassword = "";
$host = "localhost";

	$con = mysqli_connect($host, $dbUser, $dbPassword, $dbName);  
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }  

?>