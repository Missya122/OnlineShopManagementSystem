<?php

namespace Core{

    class Routing
    {
        const HOMEPAGE_CONTROLLER = "Homepage";

        public static function getCurrentController()
        {
            $request = self::parseCurrentRequest();

            $controller_name = self::getControllerName($request);
            $controller = self::createController($controller_name, $request);

            return $controller;
        }

        private static function parseCurrentRequest()
        {
            $request = trim($_SERVER['REQUEST_URI'], "/");
            $request = explode("/", $request);

            return $request;
        }

        private static function getControllerName($request)
        {
            $controller_name = $request[0] ?  ucfirst($request[0]) : self::HOMEPAGE_CONTROLLER;
            return $controller_name;
        }
      
        private static function createController($controller_name, $request = null)
        {
            $is_admin = self::isAdmin($request);
            $controller_name =  $is_admin ? "Admin{$controller_name}" : "Front{$controller_name}";

            $context = Context::getInstance();
            $context->controllerType = $is_admin ? Controller::CONTROLLER_BACK : Controller::CONTROLLER_FRONT;

            if ($is_admin) {
                $is_login = self::isAdminLogin($request);
                $is_logged = self::isAdminLogged($request);
                
                if (!$is_logged) {
                    if (!$is_login) {
                        header("Location: /admin/login");
                        exit();
                    } else {
                        $controller_name = "AdminLogin";
                    }
                }
            }
            
            if (self::isMaintenance() && !$is_admin) {
                $controller_classname = "Controllers\\FrontMaintenanceController";
            } else {
                $controller_classname = "Controllers\\{$controller_name}Controller";
                
                if (!class_exists($controller_classname)) {
                    $controller_classname = "Controllers\\FrontNotFoundController";
                    $context->controllerType = Controller::CONTROLLER_FRONT;
                }
            }
            
            $controller = new $controller_classname();
            return $controller;
        }

        private static function isAdmin($request)
        {
            return $request[0] === "admin";
        }

        private static function isAdminLogin($request)
        {
            return $request[0] === "admin" && $request[1] === "login";
        }

        private static function isAdminLogged()
        {
            return isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === true;
        }
        

        private static function isMaintenance()
        {
            return (boolean) Configuration::getValue("maintenance_mode");
        }
    }
}
