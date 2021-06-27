<?php
require_once "vendor/autoload.php";

session_start();

define("BASE_DIR", __DIR__);

use Core\Configuration;
use Core\Settings;
use Core\Database;
use Core\Routing;
use Core\Context;

use Model\Product;
use Model\Address;
use Model\Cart;
use Model\CartProduct;
use Model\Currency;
use Model\Customer;
use Model\Carrier;
use Model\Employee;
use Model\Order;

$settings = new Settings();
$connection = $settings->get(Settings::DB_CONNECTION);
$DB = new Database($connection);

Address::init();
Order::init();
Product::init();
Configuration::init();
Currency::init();
Carrier::init();
Customer::init();
Cart::init();
CartProduct::init();
Employee::init();

Configuration::installShop();

Configuration::initTimezone();

$controller = Routing::getCurrentController();
$controller->display();

$context = Context::getInstance();

