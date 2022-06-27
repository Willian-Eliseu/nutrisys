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
    $item->nome = $data->nomeUsuario;
    $item->email = $data->emailUsuario;
    $item->nut_nome = $data->nomeNutricionista;
    $item->nut_email = $data->emailNutricionista;
    $item->mensagem = $data->mensagem;
    //var_dump($data);die();
    
    if($item->saveMessage()){
        //enviar email
        $retorno = sendMail($data->nomeUsuario, $data->emailUsuario, $data->nomeNutricionista, $data->emailNutricionista, "Solicitacao de atendimento", $data->mensagem);
        
        if($retorno == 1){
            $ret = array(
                "codigo" =>  1,
                "msg" => "Mensagem enviada com sucesso"
            );
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }else{
            $ret = array(
                "codigo" =>  0,
                "msg" => "Não foi possível enviar a mensagem"
            );
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }      
    }else{
        $retorno = array(
            "codigo" =>  0,
            "msg" => "Não foi possível enviar a mensagem"
        );
        echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
    }
?>