<?php
require_once "vendor/autoload.php";

use Core\Configuration;
use Core\Settings;
use Core\Database;
use Core\Routing;
use Model\Product;

define("BASE_DIR", __DIR__);

$settings = new Settings();
$connection = $settings->get(Settings::DB_CONNECTION);
$DB = new Database($connection);

Configuration::init();
Configuration::saveValue("theme", "basic");
Configuration::saveValue("mainftenance_header", "Przerwa techniczna.");
Configuration::saveValue("maintenance_text", "Trwają prace techniczne. Wrócimy wkrótce.");
Configuration::saveValue("maintenance_mode", 1);
Configuration::saveValue("404_text", "404 not found");
Configuration::saveValue("shop_title", "Test shop");

$controller = Routing::getCurrentController();
$controller->display();

Product::init();
