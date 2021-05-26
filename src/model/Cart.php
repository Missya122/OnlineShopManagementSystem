<?php
namespace Model{

    use Core\DataModel;
    use Utils\DatabaseFields;
    
    class Cart extends DataModel
    {
        public $id_address_delivery;
        public $id_address_invoice;
        public $date_add;
        public $id_cart;
        public $id_carrier;
        public $id_customer;
        public $id_currency;

        public static $primary = 'id_cart';

        public static $fields = [
            ["name"=>"id_cart", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "extra"=>DatabaseFields::AUTO_INCREMENT ],
            ["name"=>"id_address_delivery", "type"=>DatabaseFields::FIELD_STRING, "size"=>128 ],
            ["name"=>"id_address_invoice", "type"=>DatabaseFields::FIELD_STRING, "size"=>128 ],
            ["name"=>"date_add", "type"=>DatabaseFields::FIELD_DATETIME],
            ["name"=>"id_carrier", "type"=>DatabaseFields::FIELD_INT, "size"=>10],
            ["name"=>"id_customer", "type"=>DatabaseFields::FIELD_INT, "size"=>10],
            ["name"=>"id_currency", "type"=>DatabaseFields::FIELD_INT, "size"=>10]
        ];
        
        public static $table = "cart";

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
