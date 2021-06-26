<?php
namespace Model{

    use Core\DataModel;
    use Utils\DatabaseFields;
    
    class Order extends DataModel
    { 
        public $id_order;
        public $id_address;
        public $id_carrier;
        public $id_customer;
        public $id_cart;
        public $total_price;
        public $date_add;

        public static $primary = 'id_order';

        public static $fields = [
            ["name"=>"id_order", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "extra"=>DatabaseFields::AUTO_INCREMENT],
            ["name"=>"id_address", "type"=>DatabaseFields::FIELD_INT, "size"=>10],
            ["name"=>"id_carrier", "type"=>DatabaseFields::FIELD_INT, "size"=>10],
            ["name"=>"id_customer", "type"=>DatabaseFields::FIELD_INT, "size"=>10],
            ["name"=>"id_cart", "type"=>DatabaseFields::FIELD_INT, "size"=>10],
            ["name"=>"total_price", "type"=>DatabaseFields::FIELD_DECIMAL, "size"=>[10, 2]],
            ["name"=>"date_add", "type"=>DatabaseFields::FIELD_DATETIME],
        ];
        
        public static $table = "order";

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

        public static function orderExists($idCart, $idCustomer)
        {
            global $DB;

            $sql = "SELECT id_order FROM `order` WHERE id_cart = {$idCart} AND id_customer = {$idCustomer}";

            $result = $DB->query($sql);
            return $result->fetchColumn();
        }
    }
}
