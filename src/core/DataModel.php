<?php 

namespace Core{

    use Database;

    class DataModel{
        public static $fields = [];
        public static $table = null;

        public function __construct($entity, $id = null){
            if($id){
                self::retrieve($entity, $id);
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

        public static function retrieve($entity, $id){
            global $DB;
            
            $primary = $entity::$primary;

            $fields = $DB->getSingleData($entity::$table, $id);
            if($fields){
                foreach($fields as $key => $value) {
                    $entity->$key = $value;
                }   
            }
            // why does id have string type?
        }

        public function save(){
            global $DB;

            $primary = $this::$primary;

            // modify update for manually set id on new element
            if($this->$primary){
                $DB->update($this::$table, (array)$this, $primary);
            }else{
                $DB->insert($this::$table, (array)$this);
            }
        }

        public function delete(){
            global $DB;

            $primary = $this::$primary;

            if($this->$primary){
                $DB->delete($this::$table, (array)$this, $primary);    
            }
        }
    };
}