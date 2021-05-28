<?php

namespace Core
{

    class Context
    {
        private static $instance = null;

        private function __construct()
        {
            if($this->isEmployeeLogged()) {
                $id_employee = $_SESSION['id_employee'];
                $this->setEmployeeLogged($id_employee);
            }
            
        }

        public $currentController = null;

        public $isEmployeeLogged = false;
        public $idEmployee = null;
        

        public static function getInstance()
        {
            if (self::$instance === null) {
                self::$instance = new Context();
            }

            return self::$instance;
        }

        public function setEmployeeLogged($id_employee)
        {
            $_SESSION['id_employee'] = $this->idEmployee = $id_employee;
            $_SESSION['is_employee_logged'] = $this->isEmployeeLogged = true;
        }

        public function setEmployeeLogout()
        {
            $_SESSION['id_employee'] = $this->idEmployee = null;
            $_SESSION['is_employee_logged'] = $this->isEmployeeLogged = false;
        }

        public static function isEmployeeLogged()
        {
            return isset($_SESSION['is_employee_logged']) && $_SESSION['is_employee_logged'] === true;
        }
    }
    
}
