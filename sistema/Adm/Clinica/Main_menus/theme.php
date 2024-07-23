<?php

require_once("../../configs/conexao.php"); 

$idTheme = $_POST['idTheme'];
$themeAntigo = $_POST['theme'];

if($themeAntigo === 'light'){
    $theme = 'dark';
}
else{
    $theme = 'light';
}

$res = $pdo->prepare("UPDATE usuarios SET tema = :tema WHERE id = :id");

$res->bindValue(":tema", $theme);
$res->bindValue(":id", $idTheme);

$res->execute();

echo 'Sucesso!!';

?>