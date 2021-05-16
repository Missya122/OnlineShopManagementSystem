<?php

namespace Core{

    class Routing
    {
        const HOMEPAGE_CONTROLLER = "Homepage";

        public static function getCurrentController()
        {
            $request = self::parseCurrentRequest();

            $controller_name = self::getControllerName($request);
            $controller = self::createController($controller_name);

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
      
        private static function createController($controller_name)
        {
            if (self::isMaintenance()) {
                $controller_classname = "Controllers\\FrontMaintenanceController";
            } else {
                $controller_classname = "Controllers\\Front{$controller_name}Controller";
                
            
                if (!class_exists($controller_classname)) {
                    $controller_classname = "Controllers\\FrontNotFoundController";
                }
            }
            
            $controller = new $controller_classname();
            return $controller;
        }

        private static function isMaintenance()
        {
            return (boolean) Configuration::getValue("maintenance_mode");
        }
    }
}
