<?php
namespace Controllers{

    use Core\Controller;
    use Core\Context;

    use Model\Product;

    class FrontCartController extends Controller
    {
        const TEMPLATE = "cart";

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
                'product_image_dir' => Product::getImageDirectory(),
                'total_price' => $cart->getTotalPrice()
            ]);
        }
    }
}
