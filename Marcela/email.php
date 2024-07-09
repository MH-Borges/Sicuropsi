<?php
    $nome = addslashes($_POST['nome']);
    $email = filter_var(addslashes($_POST['email']), FILTER_SANITIZE_EMAIL);
    $telefone = addslashes($_POST['telefone']);
    $mensagem = addslashes($_POST['mensagem']);

    if($nome == ""){
        echo "Preencha o campo de 'Nome completo'";
        exit();
    }
    if($email == ""){
        echo "Preencha o campo de E-mail";
        exit();
    }
    if($mensagem == ""){
        echo "O campo de mensagem está vazio!";
        exit();
    }

    $to = "universofarol@outlook.com";
    $subject = "Contato paciente ($nome) - Formulario Landing Page Marcela";
    $body = utf8_decode(
        'Nome: ' .$nome. "\r\n"."\r\n".
        'Email: ' .$email. "\r\n"."\r\n".
        'Telefone: '.$telefone. "\r\n"."\r\n".
        'Mensagem:'. "\r\n"."\r\n". $mensagem
    );

    $header = 'From:contato@universofarol.com.br'."\r\n"."Reply-To:".$email;

    if(mail($to,$subject,$body,$header)){
        echo ("Mensagem enviada com sucesso! Entrarei em contato em breve!");
    }

?>