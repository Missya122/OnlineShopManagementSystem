<?php

namespace Core;

use Database;
use PDO;

class DataModel
{
    public function __construct($id = null)
    {
        if ($id) {
            $this->retrieve($id);
            $this->{$this::$primary} = $id;
        }
    }

    public static function createTable($table, $schema)
    {
        global $DB;

        $DB->createTable(
            $table,
            $schema
        );
    }

    public static function dropTable($table)
    {
        global $DB;

        $DB->dropTable(
            $table
        );
    }

    public function retrieve($id)
    {
        global $DB;
            
        $fields = $DB->getSingleData($this::$table, $id);

        if ($fields) {
            foreach ($fields as $key => $value) {
                $this->$key = $value;
            }
        }

        // why does id have string type?
    }

    public function save()
    {
        global $DB;

        $primary = $this::$primary;
        $fields = $this->getCurrentFields();

        $fields['date_add'] = date('Y-m-d H:i:s');

        // modify update for manually set id on new element
        if ($this->$primary) {
            $DB->update($this::$table, $fields, $primary);
        } else {
            $DB->insert($this::$table, $fields);
            $this->$primary = $this->getPrimary();
        }
    }

    public function delete()
    {
        global $DB;

        $primary = $this::$primary;

        if ($this->$primary) {
            $DB->delete($this::$table, (array)$this, $primary);
        }
    }

    public static function getPrimary()
    {
        global $DB;

        $primary = static::$primary;
        $table = static::$table;

        $sql = "SELECT MAX({$primary}) id
                FROM `{$table}`";

        $result = (int) $DB->query($sql)->fetchColumn();

        return $result;
    }

    public static function getImageDirectory()
    {
        $name = static::$table;

        return "img/{$name}";
    }

    protected function getCurrentFields()
    {
        $result = [];

        $fields = (array) $this;
        $definition_fields = $this::$fields;

        foreach($fields as $field_key => $field) {
            foreach(array_column($definition_fields, 'name') as $def_field_key) {
                if($field_key === $def_field_key) {
                    $result[$field_key] = $field;
                }
            }
        }

        return $result;
    }
};

