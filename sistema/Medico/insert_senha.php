<?php
    @session_start();
    require_once("../configs/conexao.php"); 

    $novaSenha = $_POST['novaSenhaUser'];
    $repetNovaSenha = $_POST['repetNovaSenhaUser'];
    $idUser = $_POST['idUserSenha'];

	if($novaSenha == ""){
		echo 'Preencha o campo de nova senha!';
		exit();
	}
	if($repetNovaSenha == ""){
		echo 'Preencha o campo de repetição de senha!';
		exit();
	}
	if($novaSenha !== $repetNovaSenha){
		echo 'As senhas não são iguais!';
		exit();
	}

    $senha_crip = md5($novaSenha);
    $senha_temp = 'NULL';

	$res = $pdo->query("SELECT * FROM medicos WHERE id = '$idUser' LIMIT 1"); 
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);
	if(@count($dados) > 0){
		$id = $dados[0]['id'];

		$res = $pdo->prepare("UPDATE medicos SET senha = :senha, senha_Crip = :senha_Crip, senha_temp = :senha_temp WHERE id =:id");
		$res->bindValue(":senha", $novaSenha);
		$res->bindValue(":senha_Crip", $senha_crip);
		$res->bindValue(":senha_temp", $senha_temp);
		$res->bindValue(":id", $id);

		if ($res->execute()) {
			echo 'Nova senha adicionada com Sucesso!';
		} else {
			echo 'Erro: Tente novamente!';
		}
	}
?>