<?php
require_once "vendor/autoload.php";

use Core\Configuration;
use Core\Settings;
use Core\Database;
use Core\Twig;

$settings = new Settings();

$connection = $settings->get(Settings::DB_CONNECTION);
$DB = new Database($connection);

Configuration::init();
Configuration::saveValue("theme", "basic");
Configuration::saveValue("maintenance_header", "Przerwa techniczna.");
Configuration::saveValue("maintenance_text", "Trwają prace techniczne. Wrócimy wkrótce elo.");
Configuration::saveValue("shop_title", "Test shop");

$theme = Configuration::getValue("theme");
$twig = new Twig($theme);

$header = Configuration::getValue("maintenance_header");
$content = Configuration::getValue("maintenance_text");
$title = Configuration::getValue("shop_title");

$twig->display("maintenance", ["header"=>$header, "content"=>$content, "shop_title"=>$title]);
