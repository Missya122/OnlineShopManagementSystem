<?php 
namespace Utils{

    class DatabaseFields{

        const FIELD_INT = "INT";
        const FIELD_STRING = "VARCHAR";
        const FIELD_DATE = "DATE";
        const FIELD_DECIMAL = "DECIMAL";

        public static function parseField($field){
            $result = implode(" ", [
                $field["name"],
                $field["type"]."(".$field["size"].")"
            ]);

            return $result;
        }

        public static function isPrimary($field){
            return isset($field["primary"]) && ( $field["primary"] === true );
        }

        public static function parsePrimary($field){
            return "PRIMARY KEY(".$field["name"].")";
        }
    }
}
