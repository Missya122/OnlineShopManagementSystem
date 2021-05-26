<?php
require_once "vendor/autoload.php";

use Core\Configuration;
use Core\Settings;
use Core\Database;
use Core\Routing;
use Core\Context;
use Model\Product;
use Model\Cart;
use Model\Currency;
use Model\Customer;
use Model\Employee;
use Model\Order;

session_start();

define("BASE_DIR", __DIR__);

$settings = new Settings();
$connection = $settings->get(Settings::DB_CONNECTION);
$DB = new Database($connection);


Configuration::saveValue("theme", "basic");
Configuration::saveValue("maintenance_header", "Przerwa techniczna.");
Configuration::saveValue("maintenance_text", "Trwają prace techniczne, wrócimy wkrótce.");
Configuration::saveValue("maintenance_mode", 0);
Configuration::saveValue("shop_title", "Test shop");

$controller = Routing::getCurrentController();

$controller->display();

$context = Context::getInstance();

Order::init();
