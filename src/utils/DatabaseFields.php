<?php
namespace Utils{

    class DatabaseFields
    {
        const FIELD_INT = "INT";
        const FIELD_STRING = "VARCHAR";
        const FIELD_DATETIME = "DATETIME";
        const FIELD_DECIMAL = "DECIMAL";

        const AUTO_INCREMENT = "AUTO_INCREMENT";

        const NULL_VALUE = "NULL";

        const KEY_SEPARATOR = "`";
        const VALUE_SEPARATOR = "'";

        public static function prepareForCreate($field)
        {
            extract($field);
            
            $name = self::prepareValue($name, self::KEY_SEPARATOR);
            $size = isset($size) ? self::prepareSize($size) : "";
            return isset($extra) ? "{$name} {$type}{$size} {$extra}" : "{$name} {$type}{$size}";
        }

        public static function preparePrimaryConstraint($field)
        {
            return "PRIMARY KEY({$field})";
        }

        public static function preparePrimaryCond($fields, $primary)
        {
            foreach ($fields as $key => $value) {
                if ($key === $primary) {
                    $primary = self::prepareValue($primary, self::KEY_SEPARATOR);
                    $value = self::prepareValue($value, self::VALUE_SEPARATOR);
                    return "{$primary} = {$value}";
                }
            }
            return null;
        }

        public static function prepareValuesForInsert($values)
        {
            return self::formatForInsert($values, self::VALUE_SEPARATOR);
        }

        public static function prepareKeysForInsert($keys)
        {
            return self::formatForInsert($keys, self::KEY_SEPARATOR);
        }

        public static function formatForInsert($values, $separator)
        {
            foreach ($values as &$value) {
                $value = self::prepareValue($value, $separator);
            }

            return implode(",", $values);
        }

        public static function formatForUpdate($fields)
        {
            $fields_formatted = [];
            foreach ($fields as $key => $value) {
                $key = self::prepareValue($key, self::KEY_SEPARATOR);
                $value = self::prepareValue($value, self::VALUE_SEPARATOR);
                $fields_formatted[] = "{$key} = {$value}";
            }
            
            return implode(",", $fields_formatted);
        }

        public static function prepareSize($size)
        {
            if (is_array($size)) {
                $size = implode(",", $size);
            }

            return is_string($size) || is_integer($size) ? "({$size})" : "";
        }

        public static function prepareValue($value, $separator)
        {
            $null_value = self::NULL_VALUE;

            if (!$value) {
                return "{$null_value}";
            } elseif (is_string($value)) {
                return "{$separator}{$value}{$separator}";
            } else {
                return "{$value}";
            }
        }
    }
}
