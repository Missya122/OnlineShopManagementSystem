<?php

namespace Core
{
    use DataModel;
    use Utils\DatabaseFields;

    class Configuration
    {
        public static $fields = [
            ["name"=>"id_config", "type"=>DatabaseFields::FIELD_INT, "size"=>10, "extra"=>DatabaseFields::AUTO_INCREMENT ],
            ["name"=>"key", "type"=>DatabaseFields::FIELD_STRING, "size"=>255 ],
            ["name"=>"value", "type"=>DatabaseFields::FIELD_STRING, "size"=>1000 ]
            
        ];
        
        public static $table = "configuration";
        public static $primary = "id_config";


        public static function getValue($key)
        {
            global $DB;

            $table = self::$table;

            $sql = "SELECT `value` FROM {$table} WHERE `key` LIKE '{$key}'";
            $result = $DB->query($sql);

            return $result->fetchColumn();
        }

        public static function saveValue($key, $value)
        {
            $check = self::getValue($key);

            if ($check === false) {
                return self::addValue($key, $value);
            }
            
            return self::updateValue($key, $value);
        }

        protected static function addValue($key, $value)
        {
            global $DB;

            $fields = [
                "id_config" => null,
                "key" => $key,
                "value" => $value
            ];

            return $DB->insert(self::$table, $fields);
        }

        protected static function updateValue($key, $value)
        {
            global $DB;

            $fields = [
                "key" => $key,
                "value" => $value
            ];
            
            return $DB->update(self::$table, $fields, "key");
        }


        public static function init()
        {
            global $DB;

            $DB->createTable(
                self::$table,
                ['fields' => self::$fields, 'primary' => self::$primary]
            );
        }

        public static function remove()
        {
            global $DB;

            $DB->dropTable(
                self::$table
            );
        }
    }
}
