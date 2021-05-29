<?php
namespace Controllers{
    use Core\Controller;
    use Core\Configuration;
    use Model\Product;
    
    class FrontHomepageController extends Controller
    {
        const TEMPLATE = "homepage";

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
