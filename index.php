<?php 
require_once "vendor/autoload.php";

use Core\Database;
use Utils\DatabaseFields;

$config = parse_ini_file("config/db_connection.ini");
$DB = new Database($config);

$fields = [
    ["name"=>"id", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "primary"=>true ],
    ["name"=>"imie", "type"=>DatabaseFields::FIELD_STRING, "size"=>20 ],
    ["name"=>"nazwisko", "type"=>DatabaseFields::FIELD_STRING, "size"=>30 ]

];

$tableName = "krowka";


$DB->create($tableName, $fields);


