<?php 
namespace Core
{
    use PDO;
    class Database { 
        protected $connection;
        protected $config;

        public function __construct($config){
            $this->config = $config;
            $this->connetion = null;
        }

        public function create($table_name, $fields){
            
        }
        
        public function drop($table_name) {
            $sql = "DROP TABLE IF EXISTS {$table_name}";
            return $this->execute($sql);
        }
        
        public function query($sql){

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
        }
    }
}







