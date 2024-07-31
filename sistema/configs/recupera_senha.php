<?php
    require_once("conexao.php");
    @session_start();

    $chave = $_POST['chave'];
    $novaSenha = $_POST['novaSenhaUser'];
    $repetNovaSenha = $_POST['repetNovaSenhaUser'];

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

    $NovaSenhaCrip = md5($_POST['repetNovaSenhaUser']);

	$res = $pdo->query("SELECT * FROM medicos WHERE senha_Recup = '$chave' LIMIT 1"); 
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);
	if(@count($dados) > 0){
		$id = $dados[0]['id'];
		$senha_Recup = 'NULL';

		$res = $pdo->prepare("UPDATE medicos SET senha = :senha, senha_Crip = :senha_Crip, senha_Recup = :senha_Recup WHERE id =:id");
		$res->bindValue(":senha", $repetNovaSenha);
		$res->bindValue(":senha_Crip", $NovaSenhaCrip);
		$res->bindValue(":senha_Recup", $senha_Recup);
		$res->bindValue(":id", $id);
		if ($res->execute()) {
			echo 'Senha atualizada com sucesso!';
		} else {
			echo 'Erro: Tente novamente!';
		}
	}
?>