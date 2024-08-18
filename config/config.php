<?php
//start session
ob_start();
session_start();

//създаване на константи
define('SITEURL', 'http://localhost/library/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('$CREATE_DATABASE', '');

$CREATE_DATABASE = "No";
//database свързване
if (!$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD)){
    die('Не може да се осъществи връзка със сървъра:');
}

//ако има създадена база от данни:
if($CREATE_DATABASE == "Yes"){
    define('DB_NAME', $_SESSION['database_name']);
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
}

?>