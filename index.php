<?php
require_once "vendor/autoload.php";

use Core\Configuration;
use Core\Settings;
use Core\Database;
use Controllers\FrontMaintenanceController;

define("BASE_DIR", __DIR__);

$settings = new Settings();
$connection = $settings->get(Settings::DB_CONNECTION);
$DB = new Database($connection);

Configuration::init();
Configuration::saveValue("theme", "basic");
Configuration::saveValue("mainftenance_header", "Przerwa techniczna.");
Configuration::saveValue("maintenance_text", "Trwają prace techniczne. Wrócimy wkrótce elo.");
Configuration::saveValue("maintenance_mode", "true");
Configuration::saveValue("shop_title", "Test shop");

$is_maintenance = Configuration::getValue("maintenance_mode");

if ($is_maintenance) {
    $controller = new FrontMaintenanceController;
    $controller->display();
}
