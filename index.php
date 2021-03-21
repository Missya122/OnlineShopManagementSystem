<?php 
require_once "vendor/autoload.php";

use Core\Database;

$config = parse_ini_file("config/db_connection.ini");
$DB = new Database($config);





