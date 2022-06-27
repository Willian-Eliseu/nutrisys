<?php

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require "vendor/autoload.php";

// $mail = new PHPMailer();
// $mail->isSMTP();
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
// $mail->Host = 'smtp.gmail.com';
// // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
// // - 587 for SMTP+STARTTLS
// $mail->Port = 465;
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
// $mail->SMTPAuth = true;
// $mail->Username = 'projetointegradornutrisys@gmail.com';
// $mail->Password = 'rmulgtrlyoodrrno';
// $mail->setFrom('projetointegradornutrisys@gmail.com', 'NutriSys');
// //$mail->addAddress('w.eliseu@gmail.com', 'Willian Eliseu da Silva');
// // $mail->Subject = 'Teste de email com gmail';
// $mensagem = "
//     <h4>Teste de envio de mensagem</h4>
//     <p>Isto é um teste. Um teste de envio de mensagens por email.</p>
// ";
// $mail->msgHTML($mensagem);
// $mail->AltBody = 'Um exemplo de email';
// //Attach an image file
// //$mail->addAttachment('images/phpmailer_mini.png');
// if (!$mail->send()) {
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     echo 'Message sent!';
//     //Section 2: IMAP
//     //Uncomment these to save your message in the 'Sent Mail' folder.
//     #if (save_mail($mail)) {
//     #    echo "Message saved!";
//     #}
// }

function sendMail($nomeUsuario, $emailUsuario, $nomeNutri, $emailNutri, $assunto, $mensagem){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->Host = 'smtp.gmail.com';
    // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
    // - 587 for SMTP+STARTTLS
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth = true;
    $mail->Username = 'projetointegradornutrisys@gmail.com';
    $mail->Password = 'rmulgtrlyoodrrno';
    $mail->setFrom('projetointegradornutrisys@gmail.com', 'NutriSys');
    $mail->addAddress($emailNutri, $nomeNutri);
    $mail->Subject = $assunto;
    
    $msg = "
        <p>Olá $nomeNutri,</p>
        <p>O usuário $nomeUsuario enviou uma mensagem pelo sistema NutriSys</p>
        <p>Para entrar em contato, utilize este email: $emailUsuario</p>
        <p>Segue a mensagem enviada:</p>
        <p>$mensagem</p>
        <br>
        <hr>
        <br>
        <p>Não responda este email, esta é uma mensagem automática.</p>
    ";

    $mail->msgHTML($msg);
    $mail->AltBody = 'Um exemplo de email';
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');
    if (!$mail->send()) {
        return 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        return 1;        
    }
}

function contatoMail($nome, $sobrenome, $email, $celular, $assunto, $mensagem){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->Host = 'smtp.gmail.com';
    // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
    // - 587 for SMTP+STARTTLS
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth = true;
    $mail->Username = 'projetointegradornutrisys@gmail.com';
    $mail->Password = 'rmulgtrlyoodrrno';
    $mail->setFrom('projetointegradornutrisys@gmail.com', 'NutriSys');
    $mail->addAddress('projetointegradornutrisys@gmail.com', 'Contato do sistema');
    $mail->Subject = $assunto;
    
    $msg = "
        <p>O usuário $nome $sobrenome enviou uma mensagem pelo sistema NutriSys a partir da página de contato</p>
        <p>Para entrar em contato, utilize este email: $email ou entre em contato pelo celular: $celular</p>
        <p>Segue a mensagem enviada:</p>
        <p>$mensagem</p>
        <br>
        <hr>
        <br>
        <p>Não responda este email, esta é uma mensagem automática.</p>
    ";

    $mail->msgHTML($msg);
    $mail->AltBody = 'Um exemplo de email';
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');
    if (!$mail->send()) {
        return 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        return 1;        
    }
}

/*
function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}
*/