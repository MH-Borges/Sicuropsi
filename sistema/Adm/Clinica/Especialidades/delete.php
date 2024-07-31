<?php

require_once("../../../configs/conexao.php"); 

$id = $_POST['id_espec_delete'];

$res = $pdo->query("SELECT * FROM especialidade where id = '$id'"); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);

$nome_espec = $dados[0]['nome'];
$res2 = $pdo->query("SELECT * FROM medicos where especialidade = '$nome_espec'"); 
$dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados2) != 0){
    echo 'Existe um medico(a) atrelado(a) a esta especialidade, remova esta especialidade de todos os medicos antes de exclui-lá';
    exit();
}
else{
    $pdo->query("DELETE from especialidade WHERE id = '$id'");
    echo 'Excluído com Sucesso!!';
}

?>