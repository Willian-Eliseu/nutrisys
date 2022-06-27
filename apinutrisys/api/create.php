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
    $item->nome = $data->nome;
    $item->email = $data->email;
    $item->cpf = preg_replace("/[^0-9]/", "", $data->cpf);
    $item->senha = md5($data->senha);
    $item->celular = preg_replace("/[^0-9]/", "", $data->celular);
    
    if($item->createPaciente()){
        $retorno = array(
            "codigo" =>  1,
            "msg" => "Cadastro realizado com sucesso. Por favor faça login para acessar a área do usuário"
        );
        echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
    } else{
        $retorno = array(
            "codigo" =>  0,
            "msg" => "O cadastro não pôde ser realizado"
        );
        echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
    }
?>