<?php

namespace Core
{
    use PDO;
    use Utils\DatabaseFields;

    class Database
    {
        protected $connection;
        protected $config;

        public function __construct($config)
        {
            $this->config = $config;
            $this->connetion = null;
        }
        
        public function createTable($table, $schema)
        {
            if (!isset($schema['fields']) || !isset($schema['primary'])) {
                return false;
            }

            $fields = $schema['fields'];
            $primary_field = $schema['primary'];

            $fields_formatted = "";

            foreach ($fields as $field) {
                $fields_formatted .= DatabaseFields::prepareForCreate($field).",";
            }

            if ($primary_field) {
                $fields_formatted .= DatabaseFields::preparePrimaryConstraint($primary_field);
            }

            $sql = "CREATE TABLE IF NOT EXISTS `{$table}`({$fields_formatted})";
            return $this->execute($sql);
        }
        
        public function dropTable($table)
        {
            $sql = "DROP TABLE IF EXISTS `{$table}`";
            return $this->execute($sql);
        }

        public function getSingleData($table, $id)
        {
            $sql = "SELECT * FROM `{$table}` WHERE id_{$table} = {$id}";
            $result = $this->query($sql);

            if ($result) {
                return $result->fetch(PDO::FETCH_ASSOC);
            }
            
            return false;
        }

        public function getAllData($table)
        {
            $sql = "SELECT * FROM `{$table}`";
            $result = $this->query($sql);

            if ($result) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }
            
            return false;
        }

        public function insert($table, $fields)
        {
            $keys = array_keys($fields);
            $values = array_values($fields);

            $values_formatted = DatabaseFields::prepareValuesForInsert($values);
            $keys_formatted = DatabaseFields::prepareKeysForInsert($keys);
            
            $sql = "INSERT INTO `{$table}` ({$keys_formatted}) VALUES ({$values_formatted})";
            return $this->execute($sql);
        }

        public function update($table, $fields, $primary)
        {
            $fields_formatted = DatabaseFields::formatForUpdate($fields);
            $cond = DatabaseFields::preparePrimaryCond($fields, $primary);

            $sql = "UPDATE `{$table}` SET {$fields_formatted} WHERE {$cond}";
            return $this->execute($sql);
        }

        public function delete($table, $fields, $primary)
        {
            $cond = DatabaseFields::preparePrimaryCond($fields, $primary);

            $sql = "DELETE FROM `{$table}` WHERE {$cond}";
            return $this->execute($sql);
        }

        public function query($sql)
        {
            $connection = $this->getConnection();
            return $connection->query($sql);
        }

        public function execute($sql)
        {
            $connection = $this->getConnection();
            return $connection->exec($sql);
        }

        protected function getConnection()
        {
            if ($this->connection === null) {
                $this->createConnection();
            }

            return $this->connection;
        }

        protected function createConnection()
        {
            $config = $this->config;
                
            $dsn_data = implode(";", [
                "host=".$config["host"],
                "port=".$config["port"],
                "dbname=".$config["db_name"]
            ]);

            $dsn = "mysql:".$dsn_data;

            $this->connection = new PDO(
                $dsn,
                $config["db_user"],
                $config["db_pass"]
            );

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }
    
}
