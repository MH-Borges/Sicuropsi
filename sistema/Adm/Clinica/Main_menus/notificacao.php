<?php
@session_start();
require_once("../../configs/conexao.php"); 

$id_notif = $_POST['id_item_notf'];
$data = date('d/m/Y');

$res = $pdo->query("SELECT * FROM notificacoes where id = '$id_notif'"); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$status = $dados[0]['status_notif'];

if($status === 'ativa'){
    $res = $pdo->prepare("UPDATE notificacoes SET status_notif = :status_notif, data_ = :data_ WHERE id = :id");
    $res->bindValue(":status_notif", 'vista');
    $res->bindValue(":data_", $data);
    $res->bindValue(":id", $id_notif);
    $res->execute();
}
?>