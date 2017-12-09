<?php

require('wn_function.php');
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPW", "");
define("DBNAME", 'wordnet');
define("APP_HOME", "Project_I/" . basename(__DIR__));
$sqlResources = sql(DBNAME);
?>