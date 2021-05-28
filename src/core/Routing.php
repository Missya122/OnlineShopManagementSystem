<?php

namespace Core;

    use Utils\Tools;

    class Routing
    {
        const ADMIN_CONTROLLER_PREFIX = "Admin";
        const FRONT_CONTROLLER_PREFIX = "Front";

        const HOMEPAGE_CONTROLLER = "Homepage";

        public static function getCurrentController()
        {
            $request = self::parseCurrentRequest();

            $controller_name = self::getControllerName($request);
            $controller = self::createController($controller_name, $request);

            return $controller;
        }

        protected static function parseCurrentRequest()
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
                $controller_classname = self::getNotFoundController();
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

            $is_admin_logged = $context->isEmployeeLogged();

            if (!$is_admin_logged) {
                $controller_name = "Login";
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

        protected static function getNotFoundController()
        {
            return "Controllers\\FrontNotFoundController";
        }

        protected static function createControllerClassname($controller_prefix, $controller_name)
        {
            return "Controllers\\{$controller_prefix}{$controller_name}Controller";
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
    }
