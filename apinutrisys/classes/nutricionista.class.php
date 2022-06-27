<?php
    class Nutricionista{
        private $conn;
        private $db_table = "nutri_nutricionista";
        public $id;
        public $crn;
        public $nome;
        public $email;
        public $senha;
        public $ativo;
        
        // DB CONNECTION
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getNutricionistas(){
            $sqlQuery = "SELECT id, crn, nome, email, senha, ativo FROM " . $this->db_table . " WHERE ativo = 's'";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createNutricionista(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        crn = :crn,
                        nome = :nome, 
                        email = :email, 
                        senha = :senha";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->crn=htmlspecialchars(strip_tags($this->crn));
            $this->nome=htmlspecialchars(strip_tags($this->nome));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->senha=htmlspecialchars(strip_tags($this->senha));
        
            $stmt->bindParam(":crn", $this->crn);
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":senha", $this->senha);

            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ SINGLE
        public function getSingleNutricionista(){
            $sqlQuery = "SELECT id, crn, nome, email, senha, ativo FROM ". $this->db_table ." WHERE id = ? AND ativo = 's' LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['id'];
            $this->crn = $dataRow['crn'];
            $this->nome = $dataRow['nome'];
            $this->email = $dataRow['email'];
            $this->senha = $dataRow['senha'];
            $this->ativo = $dataRow['ativo'];
        }

        // LOGIN
        public function loginNutricionista(){
            $sqlQuery = "SELECT id, crn, nome, email, senha FROM ". $this->db_table ." WHERE email = :email AND senha = :senha AND ativo = 's' LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            
            $this->email=htmlspecialchars(strip_tags($this->email));
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":senha", $this->senha);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['id'];
            $this->crn = $dataRow['crn'];
            $this->nome = $dataRow['nome'];
            $this->email = $dataRow['email'];
            $this->senha = $dataRow['senha'];
        }

        // UPDATE
        public function updateNutricionista(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        crn = :crn, 
                        nome = :nome, 
                        email = :email
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->nome=htmlspecialchars(strip_tags($this->nome));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->crn=htmlspecialchars(strip_tags($this->crn));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(":crn", $this->crn);
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteNutricionista(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>