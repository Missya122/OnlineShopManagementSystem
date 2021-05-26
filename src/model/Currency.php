<?php
namespace Model{
    use Core\DataModel;
    use Utils\DatabaseFields;

    class Currency extends DataModel
    {
        public $id_currency;
        public $name;
        public $conversion_rate;

        public static $primary = "id_currency";

        public static $fields = [
            ["name"=>"id_currency", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "extra"=>DatabaseFields::AUTO_INCREMENT ],
            ["name"=>"name", "type"=>DatabaseFields::FIELD_STRING, "size"=>32 ],
            ["name"=>"conversion_rate", "type"=>DatabaseFields::FIELD_DECIMAL, "size"=> [13,6] ]
        ];

        public static $table = "currency";

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
