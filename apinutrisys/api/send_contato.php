<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    require_once '../phpmailer/sendmail.php';
    
    $data = json_decode(file_get_contents("php://input"));
        
    $retorno = contatoMail($data->nome, $data->sobrenome, $data->email, $data->celular, "Contato - sitema NutriSys", $data->mensagem);
        
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
?>