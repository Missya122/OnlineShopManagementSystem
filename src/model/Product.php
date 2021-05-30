<?php
namespace Model{

    use Core\DataModel;
    use Utils\DatabaseFields;

    class Product extends DataModel
    {
        public $id_product;
        public $name;
        public $price;
        public $short_description;
        public $long_description;
        public $date_add;
        
        public static $primary = 'id_product';

        public static $fields = [
            ["name" => "id_product", "type" => DatabaseFields::FIELD_INT, "size" => 10, "extra" => DatabaseFields::AUTO_INCREMENT],
            ["name" => "name", "type" => DatabaseFields::FIELD_STRING, "size" => 255],
            ["name" => "price", "type" => DatabaseFields::FIELD_DECIMAL, "size" => [10, 2]],
            ["name" => "short_description", "type" => DatabaseFields::FIELD_STRING, "size" => 500],
            ["name" => "long_description", "type" => DatabaseFields::FIELD_STRING, "size" => 2000],
            ["name" => "date_add", "type" => DatabaseFields::FIELD_DATETIME]

        ];
        
        public static $table = "product";

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

        public function save()
        {
            $this->date_add = date('Y-m-d H:i:s');

            parent::save();
        }

        public static function getProducts()
        {
            global $DB;
            
            return $DB->getAllData(self::$table);
        }
    }
}
