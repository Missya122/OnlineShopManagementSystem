<?php 

namespace Core{

    use Database;

    class DataModel{
        public $id;
        public static $fields = [];
        public static $table = null;

        public function __construct($entity, $id = null){
            if($id){
                self::retrieveEntity($entity, $id);
            }
        }

        public static function createTable($table, $fields){
            global $DB;

            $DB->createTable(
                $table,
                $fields
            );

        }

        public static function dropTable($table){
            global $DB;

            $DB->dropTable(
                $table
            );
        }

        public static function retrieveEntity($entity, $id){
            global $DB;

            $fields = $DB->getSingleData($entity::$table, $id);
            var_dump($fields);
        }
    };
}