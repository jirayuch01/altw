<?php

// $dbhost = "localhost";
// $dbuser = "root";
// $dbpass = "";
// $dbname = "altw";
$dbhost = "sql12.freemysqlhosting.net:3306";
$dbuser = "sql12210111";
$dbpass = "lNf3GUHcJY";
$dbname = "sql12210111";
$link = mysqli_connect($dbhost, $dbuser, $dbpass) or die('cannot connect to the server');
mysqli_select_db($link, $dbname) or die('database selection problem');
?>