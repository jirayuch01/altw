<?php

require('wn_function.php');
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPW", "");
define("DBNAME", 'wordnet');

// define("DBHOST", "us-cdbr-iron-east-05.cleardb.net:3306");
// define("DBUSER", "bcee33f3e5d0b7");
// define("DBPW", "435837ed");
// define("DBNAME", 'heroku_0837c81e28c2070');

define("APP_HOME", "Project_I/" . basename(__DIR__));
$sqlResources = sql(DBNAME);
?>