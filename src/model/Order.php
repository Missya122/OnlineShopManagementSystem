<?php
namespace Model{

    use Core\DataModel;
    use Utils\DatabaseFields;
    
    class Order extends DataModel
    {
        public $id_address_delivery;
        public $id_address_invoice;
        public $date_add;
        public $id_order;
        public $id_carrier;
        public $id_customer;
        public $id_cart;
        public $id_shipping;
        public $total_price;
        public $total_products;
        public $total_discounts;
        

        public static $primary = 'id_order';

        public static $fields = [
            ["name"=>"id_order", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "extra"=>DatabaseFields::AUTO_INCREMENT ],
            ["name"=>"id_address_delivery", "type"=>DatabaseFields::FIELD_INT, "size"=>10 ],
            ["name"=>"id_address_invoice", "type"=>DatabaseFields::FIELD_INT, "size"=>10 ],
            ["name"=>"date_add", "type"=>DatabaseFields::FIELD_DATETIME],
            ["name"=>"id_carrier", "type"=>DatabaseFields::FIELD_INT, "size"=>10],
            ["name"=>"id_customer", "type"=>DatabaseFields::FIELD_INT, "size"=>10],
            ["name"=>"id_cart", "type"=>DatabaseFields::FIELD_INT, "size"=>10,],
            ["name"=>"id_shipping", "type"=>DatabaseFields::FIELD_INT, "size"=>10,],
            ["name"=>"total_price", "type"=>DatabaseFields::FIELD_DECIMAL, "size"=>[10, 2] ],
            ["name"=>"total_products", "type"=>DatabaseFields::FIELD_INT, "size"=>10 ],
            ["name"=>"total_discounts", "type"=>DatabaseFields::FIELD_DECIMAL, "size"=>[10, 2] ]
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
    }
}
