<?php

    class DataBase {

// ---------------------------------------------------------------------

        // Informations pour se connecter à la base de données

        /**
         * Nom de domaine
         * @var string
         */
        protected $servername ;

        /**
         * Nom d'utilisateur
         * @var string
         */
        protected $username ;

        /**
         * Mot de passe
         * @var string
         */
        protected $password ;
        
        /**
         * Nom de la base de données
         * @var string
         */
        protected $dbname ;

// ---------------------------------------------------------------------

        // Methodes

        public function read (string $table) :array {

            $servername = $this -> servername ;
            $username   = $this -> username   ;
            $password   = $this -> password   ;
            $dbname     = $this -> dbname     ;

            $conn   = new mysqli ($servername, $username, $password, $dbname) ;
            $result = $conn -> query ("SELECT * FROM `".$table."`")           ;

            $resultTab = [] ;

            if ($result -> num_rows > 0) {

                while($row = $result -> fetch_assoc ()) {
                    array_push ($resultTab, $row) ;
                }

            } 

            return $resultTab ;
        }

        public function read_manual (string $request) :array {

            $servername = $this -> servername ;
            $username   = $this -> username   ;
            $password   = $this -> password   ;
            $dbname     = $this -> dbname     ;

            $conn = new mysqli($servername, $username, $password, $dbname);
            $result = $conn -> query ($request);

            $resultTab = [];

            if ($result->num_rows > 0) {
                while ($row = $result -> fetch_assoc ()) {
                    array_push ($resultTab, $row) ;
                }
            } 

            return $resultTab;
        }

        public function nb_rows (string $table) :int {

            $servername = $this -> servername ;
            $username   = $this -> username   ;
            $password   = $this -> password   ;
            $dbname     = $this -> dbname     ;

            $conn = new mysqli ($servername, $username, $password, $dbname);
            $result = $conn -> query ("SELECT COUNT(*) FROM `".$table."`");

            return ($result -> fetch_assoc ())['COUNT(*)'];
        }

        public function lastID (string $table, string $id) {

            $servername = $this -> servername ;
            $username   = $this -> username   ;
            $password   = $this -> password   ;
            $dbname     = $this -> dbname     ;

            $conn = new mysqli($servername, $username, $password, $dbname);
            $result = $conn->query("SELECT `".$id."` FROM `".$table."` ORDER BY `".$id."` DESC LIMIT 1;");
            $resultTab = [];

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push($resultTab, $row) ;
                }
            } 
            if ($resultTab == []) {
                return 0;
            } else {
                return $resultTab[0][$id];
            }
        }

        public function send (string $request) {

            $servername = $this -> servername ;
            $username   = $this -> username   ;
            $password   = $this -> password   ;
            $dbname     = $this -> dbname     ;
       
            $conn = new mysqli($servername, $username, $password, $dbname);
            $conn->query($request);
        }

        public function add (array $datas, string $table) {

            $servername = $this -> servername ;
            $username   = $this -> username   ;
            $password   = $this -> password   ;
            $dbname     = $this -> dbname     ;

            $sql_request_to_construct_key = "";
            $sql_request_to_construct_data = "";

            foreach($datas as $key => $data){
                $sql_request_to_construct_key .= $key .",";
                if (!is_string($data)) {
                    $sql_request_to_construct_data .= $data.", ";
                } else {
                    $sql_request_to_construct_data .= "'".$data."', ";
                }
            }
            $sql_request_to_construct_key = substr($sql_request_to_construct_key, 0, -1);
            $sql_request_to_construct_data = substr($sql_request_to_construct_data, 0, -2);

            $conn = new mysqli($servername, $username, $password, $dbname);
            $conn->query("INSERT INTO ".$table." (".$sql_request_to_construct_key.") VALUES (".$sql_request_to_construct_data.")");
        }

        public function modify (array $datas, string $table, string $condition) {

            $servername = $this -> servername ;
            $username   = $this -> username   ;
            $password   = $this -> password   ;
            $dbname     = $this -> dbname     ;

            $sql_request_to_construct = "";

            foreach($datas as $key => $data){
                if (!is_string($data)) {
                    $sql_request_to_construct .= $key."=".$data.", ";
                } else {
                    $sql_request_to_construct .= $key."='".$data."', ";
                }
            }

            $sql_request_to_construct = substr($sql_request_to_construct, 0, -2);

            $conn = new mysqli($servername, $username, $password, $dbname);
            $conn->query("UPDATE ".$table." SET ".$sql_request_to_construct." WHERE ".$condition);

        }

        public function add_genID (array $datas_without_id, string $table, string $id) {

            $datas_with_id = [$id => ($this -> lastID ($table, $id) + 1)] + $datas_without_id ;
            $this -> add ($datas_with_id, $table);
        }

        public function remove (string $table, string $condition) {

            $servername = $this -> servername ;
            $username   = $this -> username   ;
            $password   = $this -> password   ;
            $dbname     = $this -> dbname     ;

            $conn = new mysqli($servername, $username, $password, $dbname);

            $conn->query("DELETE FROM ".$table." WHERE ".$condition);
        }

        public function updateID (string $table, string $id) {

            $datas_table = $this -> read ($table);
            $i = 1;
            foreach ($datas_table as $data_table) {
                $data_table_modify = $data_table;
                $data_table_modify[$id] = $i;

                $condition_with_id = $id." = ".$data_table[$id];
                $this -> modify ($data_table_modify, $table, $condition_with_id);

                $i++;
            }
        }

        public function remove_genID (string $table, string $condition, string $id) {

            $this -> remove ($table, $condition);
            $this -> updateID ($table, $id);

        }

        public function read_condition (string $table, string $condition) :array {
   
            return $this -> read_manual ("SELECT * FROM ".$table." WHERE ".$condition);
        }

        public function has_datas ($table, $datas) :bool {
            if ($this -> read_condition ($table, $datas) == []) {
                return false;
            } else {
                return true;
            }
        }

        public function datas_id ($table, $datas, $id) {
            if ($this -> read_condition ($table, $datas) == []) {
                return false;
            } else {
                $empty_tab = [];

                foreach (($this -> read_condition ($table, $datas)) as $row) {
                    array_push($empty_tab , $row[$id]);
                }
                return $empty_tab;

            }
        }

        public function construct_cond_equal ($condition) :string {
            $sql_request_to_construct = "";
            foreach($condition as $key => $data){
                if (!is_string($data)) {
                    $sql_request_to_construct .= $key."=".$data." AND ";
                } else {
                    $sql_request_to_construct .= $key."='".$data."' AND ";
                }
            }

            $sql_request_to_construct = substr($sql_request_to_construct, 0, -5);

            return $sql_request_to_construct;
        }

        public function __construct (string $servername, string $username, string $password, string $dbname) {

            $this -> servername = $servername ;
            $this -> username   = $username   ;
            $this -> password   = $password   ;
            $this -> dbname     = $dbname     ;
            
        }
    } ;

// ---------------------------------------------------------------------

?>