<?php 

namespace Core{

    use Database;

    class DataModel{
        public $id;
        public static $fields = [];
        public static $table = null;

        public function __construct(){

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
    };
}