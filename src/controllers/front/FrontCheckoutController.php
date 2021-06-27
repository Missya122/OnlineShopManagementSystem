<?php
namespace Controllers{

    use Core\Controller;
    use Core\Context;

    use Core\Database;

    use Model\Carrier;
    
    class FrontCheckoutController extends Controller
    {
        const TEMPLATE = "checkout";

        public function __construct()
        {
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

            $context = Context::getInstance();
            $cart = $context->cart;
            $carriers = $this->getCarriers();

            $this->appendVariables([
                'carriers' => $carriers,
                'cart' => $cart,
                'total_price' => $cart->getTotalPrice()
            ]);
        }

        public function getCarriers()
        {
            global $DB;
            $carriers = $DB->getAllData(Carrier::$table);

            return $carriers;
        }
    }
}
