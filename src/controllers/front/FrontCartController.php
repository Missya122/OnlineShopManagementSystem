<?php
namespace Controllers{

    use Core\Controller;
    use Core\Context;
    
    use Model\CartProduct;
    use Model\Product;

    use Utils\Tools;

    class FrontCartController extends Controller
    {
        const TEMPLATE = "cart";

        public function __construct()
        {
            parent::__construct();

            $this->setupCart();
           
            $action = $this->getAction();
            
            if($action) {
                $product = $this->getProductForAction();

                if($product) {
                    $this->productAction($product, $action);
                }
            }
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

        protected function setupCart()
        {
            $context = Context::getInstance();
            $this->cart = $context->cart;
        }
        
        public function getAction()
        {
            $action = isset($this->request[1]) ? $this->request[1] : null;
            return $action;
        }

        public function getProductForAction()
        {
            $idProduct = isset($this->request[2]) ? $this->request[2] : null;
            $product = new Product($idProduct);

            return $product;
        }

        public function productAction($product, $action)
        {
            switch($action)
            {
                case "less":
                    CartProduct::changeQuantity((int) $this->cart->id_cart, (int) $product->id_product, -1, true);
                    break;
                case "more":
                    CartProduct::changeQuantity((int) $this->cart->id_cart, (int) $product->id_product, 1, true);
                    break;
                case "remove":
                    CartProduct::removeFromCart((int) $this->cart->id_cart, (int) $product->id_product);
                    break;
            }

            Tools::redirect("/cart/");
        }
    }
}
