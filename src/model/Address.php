<?php
namespace Model{
    use Core\DataModel;
    use Utils\DatabaseFields;

    class Address extends DataModel
    {
        public $id_address;
        public $firstname;
        public $lastname;
        public $country;
        public $address;
        public $city;
        public $district;
        public $postcode;
        public $email;
        public $date_add;

        public static $primary = "id_address";

        public static $fields = [
            ["name"=>"id_address", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "extra"=>DatabaseFields::AUTO_INCREMENT],
            ["name"=>"firstname", "type"=>DatabaseFields::FIELD_STRING, "size"=>255],
            ["name"=>"lastname", "type"=>DatabaseFields::FIELD_STRING, "size"=>255],
            ["name"=>"country", "type"=>DatabaseFields::FIELD_STRING, "size"=>255],
            ["name"=>"address", "type"=>DatabaseFields::FIELD_STRING, "size"=>255],
            ["name"=>"city", "type"=>DatabaseFields::FIELD_STRING, "size"=>255],
            ["name"=>"district", "type"=>DatabaseFields::FIELD_STRING, "size"=>255],
            ["name"=>"postcode", "type"=>DatabaseFields::FIELD_STRING, "size"=>255],
            ["name"=>"email", "type"=>DatabaseFields::FIELD_STRING, "size"=>255],
            ["name"=>"date_add", "type"=>DatabaseFields::FIELD_DATETIME],
        ];

        public static $table = "address";

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
