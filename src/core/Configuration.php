<?php

namespace Core
{
    use PDO;
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

            if (!$check) {
                return self::addValue($key, $value);
            }
          
            return self::updateValue($key, $value);
        }

        protected static function addValue($key, $value)
        {
            global $DB;

            $table = self::$table;
            $sql = "INSERT IGNORE INTO {$table} (`id_config`, `key`, `value`) values (null, '{$key}','{$value}')";
           
            return $DB->execute($sql);
        }

        protected static function updateValue($key, $value)
        {
            global $DB;

            $table = self::$table;
            $sql = "UPDATE {$table} SET `value` = '{$value}' WHERE `key` LIKE '{$key}'";
            
            return $DB->execute($sql);
        }

        public static function deleteValue($key)
        {
            global $DB;

            $table = self::$table;
            $sql = "DELETE FROM {$table} WHERE `key` LIKE '{$key}'";
            
            return $DB->execute($sql);
        }

        public static function getAll()
        {
            global $DB;

            $table = self::$table;
            $sql = "SELECT `key`, `value` FROM {$table}";

            $config = $DB->query($sql);
            $config = $config->fetchAll(PDO::FETCH_ASSOC);

            return $config;

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
