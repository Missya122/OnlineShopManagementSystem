<?php 
require_once "vendor/autoload.php";

use Core\Database;
use Core\Employee;

$config = parse_ini_file("config/db_connection.ini");
$DB = new Database($config);
Employee::init();
$employee = new Employee(1);

