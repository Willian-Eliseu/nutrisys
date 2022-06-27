<?php
    class Paciente{
        private $conn;
        private $db_table = "nutri_paciente";
        public $id;
        public $cpf;
        public $nome;
        public $email;
        public $senha;
        public $data_de_cadastro;
        public $ativo;
        public $celular;
        public $nut_nome;
        public $nut_email;
        public $mensagem;
        
        // DB CONNECTION
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getPacientes(){
            $sqlQuery = "SELECT id, cpf, nome, email, senha, data_de_cadastro, ativo, celular FROM " . $this->db_table . " WHERE ativo = 's'";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createPaciente(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        cpf = :cpf,
                        nome = :nome, 
                        email = :email, 
                        senha = :senha,
                        celular = :celular";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->cpf=htmlspecialchars(strip_tags($this->cpf));
            $this->nome=htmlspecialchars(strip_tags($this->nome));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->senha=htmlspecialchars(strip_tags($this->senha));
            $this->celular=htmlspecialchars(strip_tags($this->celular));
        
            $stmt->bindParam(":cpf", $this->cpf);
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":senha", $this->senha);
            $stmt->bindParam(":celular", $this->celular);
                    
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ SINGLE
        public function getSinglePaciente(){
            $sqlQuery = "SELECT id, cpf, nome, email, senha, data_de_cadastro, ativo, celular FROM ". $this->db_table ." WHERE id = ? AND ativo = 's' LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['id'];
            $this->cpf = $dataRow['cpf'];
            $this->nome = $dataRow['nome'];
            $this->email = $dataRow['email'];
            $this->senha = $dataRow['senha'];
            $this->ativo = $dataRow['ativo'];
            $this->celular = $dataRow['celular'];
        }

        // LOGIN
        public function loginPaciente(){
            $sqlQuery = "SELECT id, cpf, nome, email, senha, celular FROM ". $this->db_table ." WHERE email = :email AND senha = :senha AND ativo = 's' LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            
            $this->email=htmlspecialchars(strip_tags($this->email));
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":senha", $this->senha);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['id'];
            $this->cpf = $dataRow['cpf'];
            $this->nome = $dataRow['nome'];
            $this->email = $dataRow['email'];
            $this->senha = $dataRow['senha'];
            $this->celular = $dataRow['celular'];
        }

        // UPDATE
        public function updatePaciente(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        cpf = :cpf, 
                        nome = :nome, 
                        email = :email,
                        celular = :celular
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->nome=htmlspecialchars(strip_tags($this->nome));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->cpf=htmlspecialchars(strip_tags($this->cpf));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(":cpf", $this->cpf);
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":celular", $this->celular);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deletePaciente(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

        // CREATE
        public function saveMessage(){
            $sqlQuery = "INSERT INTO nutri_solicitacoes
                    SET
                    paciente_nome = :nome,
                    paciente_email = :email, 
                    nutri_nome = :nut_nome, 
                    nutri_email = :nut_email,
                    mensagem = :mensagem";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->nome=htmlspecialchars(strip_tags($this->nome));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->nut_nome=htmlspecialchars(strip_tags($this->nut_nome));
            $this->nut_email=htmlspecialchars(strip_tags($this->nut_email));
            $this->mensagem=htmlspecialchars(strip_tags($this->mensagem));
        
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":nut_nome", $this->nut_nome);
            $stmt->bindParam(":nut_email", $this->nut_email);
            $stmt->bindParam(":mensagem", $this->mensagem);
                    
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        public function getSolicitacoes(){
            $sqlQuery = "SELECT ns.*, DATE_FORMAT(ns.`data`, '%d/%m/%Y') AS data_sol, DATE_FORMAT(ns.`data`, '%d/%m/%Y %H:%i') AS data 
                FROM nutri_solicitacoes ns 
                LEFT JOIN nutri_paciente np ON np.email = ns.paciente_email 
                WHERE ns.paciente_email = :email 
                AND np.cpf = :cpf";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":cpf", $this->cpf);
            $stmt->execute();

            return $stmt;
        }

        public function updateSenha(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        senha = :senha
                    WHERE 
                        email = :email
                    AND
                        cpf = :cpf";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->senha=htmlspecialchars(strip_tags($this->senha));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->cpf=htmlspecialchars(strip_tags($this->cpf));
            
            $stmt->bindParam(":cpf", $this->cpf);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":senha", $this->senha);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
    }
?>