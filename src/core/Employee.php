<?php
namespace Core{

    use Utils\DatabaseFields;
    
    class Employee extends DataModel{
        public $firstname;
        public $lastname;
        public $email;
        public $password;

        public static $fields = [
            ["name"=>"id_employee", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "primary"=>true ],
            ["name"=>"firstname", "type"=>DatabaseFields::FIELD_STRING, "size"=>32 ],
            ["name"=>"lastname", "type"=>DatabaseFields::FIELD_STRING, "size"=>32 ],
            ["name"=>"email", "type"=>DatabaseFields::FIELD_STRING, "size"=>128 ],
            ["name"=>"password", "type"=>DatabaseFields::FIELD_STRING, "size"=>32 ]
        
        ];
        
        public static $table = "employee";


        public function __construct($id = null){
            parent::__construct($this, $id);
        }

        public static function init(){
            parent::createTable(self::$table, self::$fields);
        }

        public static function remove(){
            parent::dropTable(self::$table);
        }

    }
}