<?php

namespace Core{

    use Database;

    class DataModel
    {
        public function __construct($id = null)
        {
            if ($id) {
                $this->retrieve($id);
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
            
            $primary = $this::$primary;

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

            // modify update for manually set id on new element
            if ($this->$primary) {
                $DB->update($this::$table, (array)$this, $primary);
            } else {
                $DB->insert($this::$table, (array)$this);
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
    };
}
