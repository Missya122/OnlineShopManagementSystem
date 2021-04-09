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

        public static function createTable($table, $schema){
            global $DB;

            $DB->createTable(
                $table,
                $schema
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
            
            foreach($fields as $key => $field) {
                if($key === $entity::$primary) {
                    $entity->id = $field;
                }

                $entity->$key = $field;
            }
        }

        public function saveEntity(){
            global $DB;

            if(!$this->id){
                $DB->insertSingleData($this::$table, (array)$this);
            }
        }
    };
}