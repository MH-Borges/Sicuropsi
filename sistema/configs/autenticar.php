<?php
    require_once("conexao.php");
    @session_start();

    $emailNick = $_POST['emailLogin'];
    $senha = md5($_POST['senhaLogin']);

	$email = $emailNick;
	$email = strtolower($email);

	$res = $pdo->query("SELECT * FROM usuarios where email = '$email' and senha_crip = '$senha' "); 
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);

	if(@count($dados) > 0){
		$_SESSION['id_user'] = $dados[0]['id'];
		$_SESSION['nome_user'] = $dados[0]['nome_Completo'];
		$_SESSION['email_user'] = $dados[0]['email'];
		$_SESSION['nivel_user'] = $dados[0]['nivel'];
		$_SESSION['theme'] = $dados[0]['tema'];

		if($_SESSION['nivel_user'] == 'adm'){
			echo "<script language='javascript'> window.location='../Adm' </script>";
		}

	}
	else{
		echo "<script language='javascript'> window.alert('Dados Incorretos!') </script>";
		echo "<script language='javascript'> window.location='../index.php' </script>";
	}
	
?>