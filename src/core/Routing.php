<?php

namespace Core;

    use Utils\Tools;

    class Routing
    {
        const ADMIN_CONTROLLER_PREFIX = "Admin";
        const FRONT_CONTROLLER_PREFIX = "Front";

        const HOMEPAGE_CONTROLLER = "Homepage";
        const STATIC_PAGE_CONTROLLER = "Static";

        public static function getCurrentController()
        {
            $request = self::parseCurrentRequest();

            $controller_name = self::getControllerName($request);
            $controller = self::createController($controller_name, $request);

            return $controller;
        }

        public static function parseCurrentRequest()
        {
            $request = trim($_SERVER['REQUEST_URI'], "/");
            $request = explode("/", $request);

            return $request;
        }

        protected static function getControllerName($request)
        {
            $controller_name = $request[0] ?  ucfirst($request[0]) : self::HOMEPAGE_CONTROLLER;
            return $controller_name;
        }
      
        protected static function createController($controller_name, $request = null)
        {
            $context = Context::getInstance();

            $is_admin = self::isAdmin($request);

            $controller_prefix =  $is_admin ? self::ADMIN_CONTROLLER_PREFIX : self::FRONT_CONTROLLER_PREFIX;
            $context->controllerType = $is_admin ? Controller::CONTROLLER_BACK : Controller::CONTROLLER_FRONT;
     
            if ($is_admin) {
                $controller_name = self::getAdminController($controller_name, $request);
            } else {
                $controller_name = self::getFrontController($controller_name, $request);
            }
            
            $controller_classname = self::createControllerClassname($controller_prefix, $controller_name);
            
            if (!class_exists($controller_classname)) {

                if(self::pageExists($controller_name)) {
                    $controller_classname = self::getStaticController();
                } else {
                    $controller_classname = self::getNotFoundController($is_admin);
                }
            }
            
            $controller = new $controller_classname();
            return $controller;
        }

        protected static function getAdminController($controller_name, $request)
        {
            $context = Context::getInstance();

            $is_admin_logout = self::isAdminLogout($request);

            if ($is_admin_logout) {
                $context->setEmployeeLogout();
                Tools::redirectAdminLogin();
            }

            $is_admin_config = self::isAdminConfig($request);

            if($is_admin_config) {
                $controller_name = "Config";
            }

            $is_admin_settings = self::isAdminSettings($request);

            if($is_admin_settings) {
                $controller_name = "Settings";
            }

            $is_admin_logged = $context->isEmployeeLogged();


            if (!$is_admin_logged) {
                $controller_name = "Login";
            }

            $is_admin_config = self::isAdminConfig($request);

            if($is_admin_config) {
                $controller_name = "Config";
            }

            return $controller_name;
        }

        protected static function getFrontController($controller_name, $request)
        {
            $is_mainetance = self::isMaintenance();
                
            if ($is_mainetance) {
                $controller_name = "Maintenance";
            }

            return $controller_name;
        }

        protected static function getStaticController()
        {
            $controller_name = self::STATIC_PAGE_CONTROLLER;
            return "Controllers\\Front{$controller_name}Controller";
        }

        protected static function getNotFoundController($is_admin)
        {
            return $is_admin ? "Controllers\\AdminNotFoundController" : "Controllers\\FrontNotFoundController";
        }

        protected static function createControllerClassname($controller_prefix, $controller_name)
        {
            return "Controllers\\{$controller_prefix}{$controller_name}Controller";
        }

        protected static function isAdminSettings($request)
        {
            return isset($request[1]) && $request[1] === "settings";
        }

        protected static function isAdminConfig($request)
        {
            return isset($request[1]) && $request[1] === "config";
        }

        protected static function isAdminLogin($request)
        {
            return self::isAdmin($request) && self::isLogin($request);
        }

        protected static function isAdminLogout($request)
        {
            return self::isAdmin($request) && self::isLogout($request);
        }

        protected static function isAdmin($request)
        {
            return isset($request[0]) && $request[0] === "panel";
        }

        protected static function isLogin($request)
        {
            return isset($request[1]) && $request[1] === "login";
        }

        protected static function isLogout($request)
        {
            return isset($request[1]) && $request[1] === "logout";
        }

        protected static function isMaintenance()
        {
            return (boolean) Configuration::getValue("maintenance_mode");
        }

        protected static function pageExists($pagename)
        {
            $pagename = strtolower($pagename);
            $config = parse_ini_file("config/pages.ini", true);
            $static = $config['static'];

            $enabled = filter_var($static['enabled'], FILTER_VALIDATE_BOOLEAN);

            if($enabled) {
                $pages = isset($static['pages']) ? $static['pages'] : [];

                $pageIndex = array_search($pagename, $pages);

                return $pageIndex !== false;
            }

            return false; 
        }
    }
