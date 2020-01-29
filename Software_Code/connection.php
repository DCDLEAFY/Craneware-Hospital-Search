<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'silva.computing.dundee.ac.uk');
define('DB_USERNAME', '19ac3u09');
define('DB_PASSWORD', 'cba123');
define('DB_NAME', '19ac3d09');

/* Attempt to connect to MySQL database */
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
