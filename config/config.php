<?php
$dbName = "url";
$dbUser = "links";
$dbPassword = "";
$host = "localhost";

$con = mysqli_connect($host, $dbUser, $dbPassword, $dbName) {
    if(mysqli_connect_errno()){
        die("Connection Failed". mysqli_connect_error());
    }
}

?>