<?php

namespace Core;

use Model\Cart;
use Model\Customer;

use Core\Configuration;

    class Context
    {
        private static $instance = null;

        public $currentController = null;

        public $isEmployeeLogged = false;
        public $idEmployee = null;

        public $cart = null;
        public $customer = null;

        private function __construct()
        {
            if($this->isEmployeeLogged()) {
                $id_employee = $_SESSION['id_employee'];
                $this->setEmployeeLogged($id_employee);
            }

            $this->setupCustomer();
            $this->setupCurrency();
            $this->setupCart();
            

            if(!$this->areMatching($this->cart, $this->customer))
            {
                $this->cart->id_customer = $this->customer->id_customer;
                $this->cart->save();
            }
        }

        public static function getInstance()
        {
            if (self::$instance === null) {
                self::$instance = new Context();
            }

            return self::$instance;
        }

        public function setupCustomer()
        {
            $idCustomer = isset($_SESSION['id_customer']) ? $_SESSION['id_customer'] : null;
            $this->customer = new Customer($idCustomer);

            if(!$idCustomer) {
                $this->customer->save();
                $this->set('id_customer', $this->customer->id_customer);
            }
        }

        public function setupCart()
        {
            $idCart = isset($_SESSION['id_cart']) ? $_SESSION['id_cart'] : null;
            $this->cart = new Cart($idCart);

            if(!$idCart) {
                $this->cart->save();
                $this->set('id_cart', $this->cart->id_cart);
            }
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

        public static function setupCurrency()
        {
            $_SESSION['currency'] = Configuration::getValue('currency');
        }

        protected function areMatching($cart, $customer)
        {
            return $cart->id_customer === $customer->id_customer;
        }

        protected function get($key)
        {
            return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        }

        protected function set($key, $value)
        {
            $_SESSION[$key] = $value;
        }
    }

