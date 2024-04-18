<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$db=$_SESSION['db'];
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Lic180990');
define('DB_NAME', $db);
define('DB_PORT','3306');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_NAME, DB_PORT);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>