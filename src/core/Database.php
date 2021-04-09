<?php 
namespace Core
{
    use PDO;
    use Utils\DatabaseFields;

    class Database { 
        protected $connection;
        protected $config;

        public function __construct($config){
            $this->config = $config;
            $this->connetion = null;
        }
        
        public function createTable($table, $schema){

            if(!isset($schema['fields']) || !isset($schema['primary'])) {
                return false;
            }

            $fields = $schema['fields'];
            $primary_field = $schema['primary'];

            $sql = "CREATE TABLE IF NOT EXISTS {$table}(";

            foreach ($fields as $field){
                $sql .= DatabaseFields::parseField($field).",";
            }

            if($primary_field){
                $sql .= DatabaseFields::parsePrimary($primary_field);
            }

            $sql .= ")";
            return $this->execute($sql);
        }
        
        public function dropTable($table) {
            $sql = "DROP TABLE IF EXISTS {$table}";
            return $this->execute($sql);
        }

        public function getSingleData($table, $id){
            $sql = "SELECT * FROM {$table} WHERE id_{$table} = {$id}";
            $result = $this->query($sql);

            if($result){
                return $result->fetch(PDO::FETCH_ASSOC);
            }
            
            return false;
        }

        public function getAllData($table){
            $sql = "SELECT * FROM {$table}";
            return $this->query($sql);
        }

        public function insertSingleData($table, $fields){
            $sql = "INSERT INTO {$table} ";
        }
        
        public function query($sql){
            $connection = $this->getConnection();
            return $connection->query($sql);
        }

        public function execute($sql){
            $connection = $this->getConnection();
            return $connection->exec($sql);
        }

        protected function getConnection() {
            if($this->connection === null) {
                $this->createConnection();
            }

            return $this->connection;
        }

        protected function createConnection(){
            
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







