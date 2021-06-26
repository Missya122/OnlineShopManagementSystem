<?php
namespace Model{

    use Core\DataModel;
    use Utils\DatabaseFields;

    use PDO;
    
    class CartProduct extends DataModel
    {
        public $id_cart_product;
        public $id_cart;
        public $id_product;
        public $quantity;

        public static $primary = 'id_cart_product';

        public static $fields = [
            ["name"=> "id_cart_product", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "extra" => DatabaseFields::AUTO_INCREMENT ],
            ["name"=> "id_cart", "type"=>DatabaseFields::FIELD_INT, "size"=>10 ],
            ["name"=> "id_product", "type"=>DatabaseFields::FIELD_INT, "size"=>10 ],
            ["name"=> "quantity", "type"=>DatabaseFields::FIELD_INT, "size"=>10],
            ["name" => "date_add", "type" => DatabaseFields::FIELD_DATETIME]
        ];
        
        public static $table = "cart_product";

        // refactor, remove this paramater
        public function __construct($id = null)
        {
            parent::__construct($id);
        }

        public static function init()
        {
            parent::createTable(self::$table, ['fields' => self::$fields, 'primary' => self::$primary ]);
        }

        public static function remove()
        {
            parent::dropTable(self::$table);
        }

        public static function getProducts($idCart)
        {
            global $DB;

            $productTable = Product::$table;
            $table = static::$table;

            $sql = "SELECT cp.id_product, SUM(cp.quantity) quantity, p.name,
            p.price, p.image FROM {$table} cp
            LEFT JOIN {$productTable} p ON p.id_product = cp.id_product
            WHERE cp.id_cart = {$idCart}
            GROUP BY cp.id_product ORDER BY cp.date_add ASC";
            
            $result = $DB->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function addToCart($idCart, $idProduct, $quantity = 1)
        {
            $cartProduct = new CartProduct();

            $cartProduct->id_cart = $idCart;
            $cartProduct->id_product = $idProduct;
            $cartProduct->quantity = $quantity;

            $cartProduct->save();
        }

        public static function removeFromCart($idCart, $idProduct)
        {
            $idCartProduct = self::getIdCartProduct($idCart, $idProduct);

            $cartProduct = new CartProduct($idCartProduct);
            $cartProduct->remove();
        }

        public static function changeQuantity($idCart, $idProduct, $quantity)
        {
            $idCartProduct = self::getIdCartProduct($idCart, $idProduct);

            $cartProduct = new CartProduct($idCartProduct);
            $cartProduct->quantity = $quantity;

            if($cartProduct->quantity <= 0) {
                $cartProduct->remove();
            } else {
                $cartProduct->save();
            }
        }

        public static function getIdCartProduct($idCart, $idProduct)
        {
            global $DB;

            $table = $this::$table;
            $sql = "SELECT * FROM {$table} WHERE id_cart = {$idCart} AND id_product = {$idProduct} ORDER BY date_add ASC";

            $result = $DB->query($sql);
            return $result->fetch();
        }
    }
}
