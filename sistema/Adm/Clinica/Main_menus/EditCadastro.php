<?php
@session_start();
require_once("../../configs/conexao.php"); 

$nomeCompEdit = $_POST['nomeCompEdit'];
$telefoneContatoEdit = $_POST['telefoneContatoEdit'];
$idUser = $_POST['idUser'];

$res = $pdo->prepare("UPDATE usuarios SET nome_Completo = :nome_Completo, telefone = :telefone WHERE id = :id");

$res->bindValue(":nome_Completo", $nomeCompEdit);
$res->bindValue(":telefone", $telefoneContatoEdit);
$res->bindValue(":id", $idUser);

$res->execute();

echo 'Cadastro alterado com Sucesso!!';

?>