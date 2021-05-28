<?php
namespace Model{

    use Core\DataModel;
    use Utils\DatabaseFields;
    
    class Employee extends DataModel
    {
        public $id_employee;
        public $firstname;
        public $lastname;
        public $email;
        public $login;
        public $password;

        public static $primary = 'id_employee';

        public static $fields = [
            ["name"=>"id_employee", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "extra"=>DatabaseFields::AUTO_INCREMENT],
            ["name"=>"firstname", "type"=>DatabaseFields::FIELD_STRING, "size"=>32],
            ["name"=>"lastname", "type"=>DatabaseFields::FIELD_STRING, "size"=>32],
            ["name"=>"email", "type"=>DatabaseFields::FIELD_STRING, "size"=>128],
            ["name"=>"login", "type"=>DatabaseFields::FIELD_STRING, "size"=>32],
            ["name"=>"password", "type"=>DatabaseFields::FIELD_STRING, "size"=>32]
        ];
        
        public static $table = "employee";

        public function __construct($id = null)
        {
            parent::__construct($id);
        }

        public function checkPassword($password)
        {
            // md5 here
            return $this->password === $password;
        }

        public static function init()
        {
            parent::createTable(self::$table, ['fields' => self::$fields, 'primary' => self::$primary ]);
        }

        public static function remove()
        {
            parent::dropTable(self::$table);
        }

        public static function getByLogin($login)
        {
            global $DB;
            $table = self::$table;

            $sql = "SELECT `id_employee` FROM {$table}
                    WHERE `login` LIKE '{$login}'";
           
            return $DB->query($sql)->fetchColumn();
        }
    }
}
