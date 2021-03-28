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
        
        
        public function createTable($table_name, $fields){
            $sql = "CREATE TABLE IF NOT EXISTS {$table_name}(";

            $primary_field = null;

            foreach ($fields as $field){
                if(DatabaseFields::isPrimary($field)){
                   $primary_field = $field;
                }

                $sql .= DatabaseFields::parseField($field).",";
            }

            if($primary_field){
                $sql .= DatabaseFields::parsePrimary($primary_field);
            }

            $sql .= ")";
            return $this->execute($sql);
        }
        
        public function dropTable($table_name) {
            $sql = "DROP TABLE IF EXISTS {$table_name}";
            return $this->execute($sql);
        }

        public function getSingleData($table_name, $id){
            $sql = "SELECT * FROM {$table_name} WHERE id_{$table_name} = {$id}";
            $result = $this->query($sql);

            if($result){
                return $result->fetch(PDO::FETCH_ASSOC);
            }
            
            return false;
        }

        public function getAllData($table_name){
            $sql = "SELECT * FROM {$table_name}";
            return $this->query($sql);
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







