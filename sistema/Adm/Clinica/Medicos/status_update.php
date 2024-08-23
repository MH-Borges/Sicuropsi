<?php
    @session_start();
    require_once("../../../configs/conexao.php"); 

    $id_Medico = $_POST['id_Medico'];
    $status_perfil = $_POST['status_perfil'];

    if($status_perfil == "" || $status_perfil == null){
        $status_perfil = 'inativo';
    } 
    if($status_perfil == "ativo"){
        $status_perfil = 'inativo';
    }else{
        $status_perfil = 'ativo';
    }

    // ===== INSERÇÃO DE DADOS NO BANCO =====
    $res = $pdo->prepare("UPDATE medicos SET status_perfil = :status_perfil WHERE id = :id");
        
    $res->bindValue(":id", $id_Medico);
    $res->bindValue(":status_perfil", $status_perfil);

    if ($res->execute()) {
        echo 'Status atualizado com Sucesso!!';
    } else {
        echo 'Erro: Tente novamente!';
    }
?>