<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/connection.class.php';
    include_once '../classes/nutricionista.class.php';

    $database = new Connection();
    $db = $database->getConnection();
    $items = new Nutricionista($db);
    $stmt = $items->getNutricionistas();
    $itemCount = $stmt->rowCount();

    // echo json_encode($itemCount);
    if($itemCount > 0){
        $nutricionistaArr = array();
        $nutricionistaArr["body"] = array();
        $nutricionistaArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "nome" => $nome,
                "email" => $email,
                "crn" => $crn,
                "ativo" => $ativo
            );
            array_push($nutricionistaArr["body"], $e);
        }
        echo json_encode($nutricionistaArr);
    }
    else{
        http_response_code(404);
        echo json_encode(0);
    }
?>