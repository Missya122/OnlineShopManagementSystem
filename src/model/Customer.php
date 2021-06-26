<?php
namespace Model{

    use Core\DataModel;
    use Utils\DatabaseFields;
    
    class Customer extends DataModel
    {
        public $id_customer;
        public $firstname;
        public $lastname;
        public $email;
        public $password;

        public static $primary = 'id_customer';

        public static $fields = [
            ["name"=>"id_customer", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "extra"=>DatabaseFields::AUTO_INCREMENT ],
            ["name"=>"firstname", "type"=>DatabaseFields::FIELD_STRING, "size"=>32 ],
            ["name"=>"lastname", "type"=>DatabaseFields::FIELD_STRING, "size"=>32 ],
            ["name"=>"email", "type"=>DatabaseFields::FIELD_STRING, "size"=>128 ],
            ["name"=>"password", "type"=>DatabaseFields::FIELD_STRING, "size"=>32 ],
            ["name" => "date_add", "type" => DatabaseFields::FIELD_DATETIME]
        ];
        
        public static $table = "customer";

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
