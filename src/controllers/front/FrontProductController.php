<?php
namespace Controllers{
    use Core\Controller;
    use Core\Configuration;
    use Core\Routing;

    use Model\Product;
    
    class FrontProductController extends Controller
    {
        const TEMPLATE = "product";

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

            $idProduct = $this->getIdProduct();
            $product = new Product($idProduct);

            $this->appendVariables([
                'image_dir' => $product->getImageDirectory(),
                'product' => $product
            ]);
        }

        protected function getIdProduct()
        {
            $request = Routing::parseCurrentRequest();
            return (int) array_pop($request);
        }
    }
}
