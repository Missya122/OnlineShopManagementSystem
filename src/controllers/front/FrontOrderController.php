<?php

namespace Controllers{

    use Core\Controller;
    use Core\Context;
    use Core\Database;

    use Utils\Tools;

    use Model\Order;
    use Model\Cart;
    use Model\Customer;
    use Model\Address;

    class FrontOrderController extends Controller
    {
        public $error;
        public $order;
        public $address;

        const TEMPLATE = "order";

        public function __construct()
        {
            $this->context = Context::getInstance();
            $this->error = false;

            if(Order::orderExists(
                $this->context->cart->id_cart, 
                $this->context->customer->id_customer
            )) {
                $this->error = true;
            }
            
            if(Tools::isSubmit('new_order') && !$this->error) {
                
                $this->address = $this->getAddress();
                
                if(!$this->error) {
                    $this->order = $this->createOrder($this->address);
                    $this->refreshCart();
                }
            }

            parent::__construct();
        }

        public function init()
        {
            parent::init();

            $this->template = self::TEMPLATE;
        }

        public function initVariables()
        {
            parent::initVariables();
      
            $this->appendVariables([
                'order_error' => $this->error,
                'order' => (array) $this->order,
                'address' => (array) $this->address,
            ]);
        }

        protected function getAddress()
        {
            $address = new Address();

            foreach((array) $address as $key => $field) {
                   
                if($key === Address::$primary || $key === 'date_add') {
                    continue;
                }

                $value = Tools::getValue($key);

                if(!$value) {
                    $this->error = true;  
                    continue;
                }

                $address->$key = $value;
            }

            if(!$this->error) {
                $address->save();
            }
            

            return $address;
        }

        protected function createOrder($address)
        { 
            $order = new Order();

            $order->id_address = $address->id_address;
            $order->id_customer = $this->context->customer->id_customer;
            $order->id_cart = $this->context->cart->id_cart;
            $order->total_price = $this->context->cart->getTotalPrice();

            $order->id_carrier = $this->getCarrier();
            $order->order_note = $this->getOrderNotes();

            $order->save();

            return $order;
        }

        protected function getOrderNotes()
        {
            return Tools::getValue('order_notes');
        }

        protected function getCarrier()
        {
            $idCarrier = Tools::getValue('id_carrier');

            return $idCarrier;
        }

        protected function refreshCart()
        {
            $newCart = new Cart();
            $newCart->save();

            $_SESSION['id_cart'] = $newCart->id_cart;
        }
    }
}
