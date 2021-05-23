<?php

namespace Core
{

    class Context
    {
        private static $instance = null;
        private function __construct()
        {
        }

        public $currentController = null;
        

        public static function getInstance()
        {
            if (self::$instance === null) {
                self::$instance = new Context();
            }

            return self::$instance;
        }
    }
    
}
