<?php 
namespace Utils{

    class DatabaseFields{

        const FIELD_INT = "INT";
        const FIELD_STRING = "VARCHAR";
        const FIELD_DATE = "DATE";
        const FIELD_DECIMAL = "DECIMAL";

        const AUTO_INCREMENT = "AUTO_INCREMENT";

        const NULL_VALUE = "NULL";

        const KEY_SEPARATOR = "`";
        const VALUE_SEPARATOR = "'";

        public static function prepareForCreate($field){
            extract($field);

            return isset($extra) ? "{$name} {$type}({$size}) {$extra}" : "{$name} {$type}({$size})";
        }

        public static function preparePrimaryConstraint($field){
            return "PRIMARY KEY({$field})";
        }

        public static function preparePrimaryCond($fields, $primary){
            foreach($fields as $key => $value){
                if($key === $primary){
                    return "{$primary} = {$value}";
                }
            }
            return null;
        }

        public static function prepareValuesForInsert($values){
           return self::formatForInsert($values, self::VALUE_SEPARATOR);
        }

        public static function prepareKeysForInsert($keys){
            return self::formatForInsert($keys, self::KEY_SEPARATOR);
        }

        public static function formatForInsert($values, $separator){
            foreach($values as &$value){
                $value = self::prepareValue($value, $separator);
            }

            return implode(",", $values);
        }

        public static function formatForUpdate($fields){
            $fields_formatted = [];
            foreach($fields as $key => $value){
                $value = self::prepareValue($value, self::VALUE_SEPARATOR);
                $fields_formatted[] = "{$key} = {$value}";
            }
            
            return implode(",", $fields_formatted);
        }

        public static function prepareValue($value, $separator){
            $null_value = self::NULL_VALUE;

            if(!$value){
                return "{$null_value}";
            }else if(is_string($value)){
                return "{$separator}{$value}{$separator}";
            }else{
                return "{$value}";
            }
        }
    }
}
