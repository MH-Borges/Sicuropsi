<?php
require_once("../../configs/conexao.php"); 

$senhaAntiga = $_POST['antigaSenha'];
$novaSenha = $_POST['novaSenha'];
$confirmaNovaSenha = $_POST['confirmaNovaSenha'];

$senha_crip = md5($novaSenha);

$idUser = $_POST['idUserSenha'];
$senhaUserSemAlteracoes = $_POST['senhaUserSemAlteracoes'];

if($senhaAntiga == ""){
    echo 'Por-favor preencha o campo de senha antiga!';
    exit();
}

if($novaSenha == ""){
    echo 'Por-favor preencha o campo de nova senha!';
    exit();
}

if($confirmaNovaSenha == ""){
    echo 'Por-favor preencha o campo de confirma nova senha!';
    exit();
}

if($senhaAntiga != $senhaUserSemAlteracoes){
    echo 'Senha antiga não coicide com senhas cadastradas no banco de dados!';
    exit();
}

if($novaSenha != $confirmaNovaSenha){
    echo 'Nova senha e confirma nova senha não coicidem!';
    exit();
}

if($novaSenha == $senhaUserSemAlteracoes){
    echo 'Nova senha é identica a senha já cadastrada!';
    exit();
}

$res = $pdo->prepare("UPDATE usuarios SET senha = :senha, senha_Crip = :senha_Crip WHERE id = :id");

$res->bindValue(":senha", $novaSenha);
$res->bindValue(":senha_Crip", $senha_crip);

$res->bindValue(":id", $idUser);

$res->execute();


echo 'Senha alterada com Sucesso!';

?>