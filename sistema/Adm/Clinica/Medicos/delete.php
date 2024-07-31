<?php

require_once("../../../configs/conexao.php"); 
$id = $_POST['id_medico_delete'];
$pdo->query("DELETE from medicos WHERE id = '$id'");
echo 'Excluído com Sucesso!!';

?>