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
    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getSinglePaciente();
    if($item->nome != null){
        // create array
        $emp_arr = array(
            "id" =>  $item->id,
            "nome" => $item->nome,
            "email" => $item->email,
            "cpf" => $item->cpf,
            "data_de_cadastro" => $item->data_de_cadastro,
            "ativo" => $item->ativo,
            "celular" => $item->celular
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Paciente nao encontrado.");
    }
?>