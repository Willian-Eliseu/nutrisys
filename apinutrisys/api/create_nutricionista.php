<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/connection.class.php';
    include_once '../classes/nutricionista.class.php';

    $database = new Connection();
    $db = $database->getConnection();
    $item = new Nutricionista($db);
    $data = json_decode(file_get_contents("php://input"));
    $item->nome = $data->nome;
    $item->email = $data->email;
    $item->crn = preg_replace("/[^0-9]/", "", $data->crn);
    $item->senha = md5($data->senha);
    
    if($item->createNutricionista()){
        $retorno = array(
            "codigo" =>  1,
            "msg" => "Cadastro realizado com sucesso. Você será listado em nosso sistema como nutricionista disponível"
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