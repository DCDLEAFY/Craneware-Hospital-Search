<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$servername="silva.computing.dundee.ac.uk";
$username="19agileteam12";
$password="2437.at12.7342";

/* Attempt to connect to MySQL database */
$con = mysqli_connect($servername, $username, $password);

// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
