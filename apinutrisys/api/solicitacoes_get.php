<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/connection.class.php';
    include_once '../classes/paciente.class.php';
    require_once '../phpmailer/sendmail.php';

    $database = new Connection();
    $db = $database->getConnection();
    $item = new Paciente($db);
    $data = json_decode(file_get_contents("php://input"));
    $item->email = $data->email;
    $item->cpf = $data->cpf;
    $stmt = $item->getSolicitacoes();
    $itemCount = $stmt->rowCount();

    //var_dump($data);die();
    //var_dump($stmt->fetch(PDO::FETCH_ASSOC));die();
        
    if($itemCount > 0){
        $solicitacoes = array();
        $solicitacoes["body"] = array();
        $solicitacoes["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "nutri_nome" => $nutri_nome,
                "nutri_email" => $nutri_email,
                "data_sol" => $data_sol,
                "data" => $data,
                "mensagem" => $mensagem
            );
            array_push($solicitacoes["body"], $e);
        }
        echo json_encode($solicitacoes);
    }else{
        $retorno = array(
            "codigo" =>  0,
            "msg" => "Ainda não existem registros"
        );
        echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
    }
?>