<?php
namespace Core{

    use Utils\DatabaseFields;
    
    class Employee extends DataModel{
        public $id_employee;
        public $firstname;
        public $lastname;
        public $email;
        public $password;

        public static $primary = 'id_employee';

        public static $fields = [
            ["name"=>"id_employee", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "extra"=>DatabaseFields::AUTO_INCREMENT ],
            ["name"=>"firstname", "type"=>DatabaseFields::FIELD_STRING, "size"=>32 ],
            ["name"=>"lastname", "type"=>DatabaseFields::FIELD_STRING, "size"=>32 ],
            ["name"=>"email", "type"=>DatabaseFields::FIELD_STRING, "size"=>128 ],
            ["name"=>"password", "type"=>DatabaseFields::FIELD_STRING, "size"=>32 ]
        ];
        
        public static $table = "employee";

        // refactor, remove this paramater
        public function __construct($id = null){
            parent::__construct($this, $id);
        }

        public static function init(){
            parent::createTable(self::$table, ['fields' => self::$fields, 'primary' => self::$primary ]);
        }

        public static function remove(){
            parent::dropTable(self::$table);
        }

    }
}