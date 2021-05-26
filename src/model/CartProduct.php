<?php
namespace Model{

    use Core\DataModel;
    use Utils\DatabaseFields;
    
    class CartProduct extends DataModel
    {
        public $id_cart;
        public $id_product;
        public $quantity;

        public static $primary = 'id_cart';

        public static $fields = [
            ["name"=>"id_cart", "type"=>DatabaseFields::FIELD_INT, "size"=>10 ],
            ["name"=>"id_product", "type"=>DatabaseFields::FIELD_INT, "size"=>10 ],
            ["name"=>"quantity", "type"=>DatabaseFields::FIELD_INT, "size"=>10]
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
    }
}
