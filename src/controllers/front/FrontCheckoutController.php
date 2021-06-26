<?php
namespace Controllers{

    use Core\Controller;
    use Core\Context;

    use Model\Product;
    
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

            $this->appendVariables([
                'cart' => $cart,
                'total_price' => $cart->getTotalPrice()
            ]);
        }
    }
}
