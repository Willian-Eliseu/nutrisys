<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/connection.class.php';
    include_once '../classes/paciente.class.php';
    
    $database = new Connection();
    $db = $database->getConnection();    
    $item = new Paciente($db);    
    $data = json_decode(file_get_contents("php://input"));
    $item->email = $data->email;
    $item->senha = md5($data->senha);
    $item->loginPaciente();
            
    if($item->nome != null){
        $retorno = array(
            "id" =>  $item->id,
            "nome" => $item->nome,
            "email" => $item->email,
            "cpf" => $item->cpf,
            "senha" => $item->senha,
            "celular" => $item->celular,
            "codigo" => 1
        );
      
        http_response_code(200);
        echo json_encode($retorno);
    } else{
        $retorno = array(
            "msg" =>  "O email informado não foi encontrado",
            "codigo" => 0
        );

        http_response_code(200);
        echo json_encode($retorno);
    }
?>