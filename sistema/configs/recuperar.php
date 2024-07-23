<?php

require_once("conexao.php");

$email = $_POST['emailRecuperaSenha'];

if($email == ""){
    echo 'Preencha o campo de recuperação de e-mail!';
    exit();
}

$email = strtolower($email);

$res = $pdo->query("SELECT * FROM usuarios where email = '$email' "); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);

if(@count($dados) > 0){

    $idUser = $dados[0]['id'];
    $chave_recuperar_senha = password_hash($idUser, PASSWORD_DEFAULT);
 
    $res = $pdo->prepare("UPDATE usuarios SET senha_Recup = :senha_Recup WHERE id = :id");
    $res->bindValue(":senha_Recup", $chave_recuperar_senha);
    $res->bindValue(":id", $idUser);
    $res->execute();

    $link = "https://www.autoinove.com.br/sistema/atualiza_senha.php?chave=$chave_recuperar_senha";
    
   //ENVIAR O EMAIL COM A SENHA
    $destinatario = $email;
    $assunto = 'Auto Inove - Recuperação de Senha';
    $mensagem = utf8_decode('Prezado(a) ' . $dados[0]['nome_Completo'] . ".<br><br>Você solicitou alteração de senha para o usuario" . $dados[0]['email'] .  ".<br><br>Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: <br><br><a href='" . $link . "'>" . $link . "</a><br><br>Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>");
    $cabecalhos = "From: ".$email;
    mail($destinatario, $assunto, $mensagem, $cabecalhos);

    echo 'Link para a recuperação de senha enviado para o e-mail informado!';
    
}else{
   echo 'Este e-mail não está cadastrado!';
}

?>