<?php
namespace Controllers{
    use Core\FrontController;
    use Core\Configuration;
    use Model\Product;
    
    class FrontProductsController extends FrontController
    {
        const TEMPLATE = "products/product-list";

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

            $products = Product::getProducts();

            $this->appendVariables(['products' => $products]);
        }
    }
}
