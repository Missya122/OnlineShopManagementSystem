<?php
namespace Model{

    use Core\DataModel;
    use Utils\DatabaseFields;

    use Utils\Tools;
    
    class Cart extends DataModel
    {
        public $id_cart;
        public $id_address;
        public $id_customer;
        public $date_add;

        public static $primary = 'id_cart';

        public static $fields = [
            ["name"=>"id_cart", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "extra"=>DatabaseFields::AUTO_INCREMENT ],
            ["name"=>"id_address", "type"=>DatabaseFields::FIELD_INT, "size"=>10],
            ["name"=>"id_customer", "type"=>DatabaseFields::FIELD_INT, "size"=>10],
            ["name"=>"date_add", "type"=>DatabaseFields::FIELD_DATETIME],
        ];
        
        public static $table = "cart";

        // refactor, remove this paramater
        public function __construct($id = null)
        {
            parent::__construct($id);

            if($id) {
              $this->refreshProducts();  
            }

            $action = Tools::getValue('action');

            if($action && $action === 'add') {
                $idProduct = Tools::getValue('id_product');

                $this->addProduct($idProduct);
            }
        }

        public static function init()
        {
            parent::createTable(self::$table, ['fields' => self::$fields, 'primary' => self::$primary]);
        }

        public static function remove()
        {
            parent::dropTable(self::$table);
        }

        public function addProduct($idProduct)
        {
            CartProduct::addToCart($this->id_cart, $idProduct);
            $this->refreshProducts();  
        }

        public function removeProduct($idProduct)
        {
            CartProduct::removeFromCart($this->id_cart, $idProduct);
            $this->refreshProducts();  
        }

        public function changeProductQuantity($idProduct, $quantity)
        {
            CartProduct::changeQuantity($this->id_cart, $idProduct, $quantity);
            $this->refreshProducts();  
        }

        protected function refreshProducts()
        {
            $this->products = $this->getProducts();
            $this->total_price = $this->getTotalPrice();
        }

        public function getProducts()
        {
            $products = CartProduct::getProducts($this->id_cart);

            foreach($products as &$product) {
                $product['price'] = (float)$product['price'];
                $product['quantity'] = (int)$product['quantity'];
            }

            return $products ? $products : null;
        }

        public function getTotalPrice()
        {
            $total = 0.0;

            if(!$this->products) {
                return $total;
            }

            foreach($this->products as $product) {
                $total += $product['price'] * $product['quantity'];
            }

            return $total;
        }
    }
}
