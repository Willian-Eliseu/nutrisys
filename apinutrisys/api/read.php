<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/connection.class.php';
    include_once '../classes/paciente.class.php';

    $database = new Connection();
    $db = $database->getConnection();
    $items = new Paciente($db);
    $stmt = $items->getPacientes();
    $itemCount = $stmt->rowCount();

    echo json_encode($itemCount);
    if($itemCount > 0){
        
        $pacienteArr = array();
        $pacienteArr["body"] = array();
        $pacienteArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "nome" => $nome,
                "email" => $email,
                "cpf" => $cpf,
                "data_de_cadastro" => $data_de_cadastro,
                "ativo" => $ativo,
                "celular" => $celular
            );
            array_push($pacienteArr["body"], $e);
        }
        echo json_encode($pacienteArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "Nenhum registro encontrado.")
        );
    }
?>