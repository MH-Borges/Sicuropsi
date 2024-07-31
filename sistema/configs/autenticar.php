<?php
    require_once("conexao.php");
    @session_start();

    $email = strtolower($_POST['emailLogin']);
    $senha = md5($_POST['senhaLogin']);

	$res = $pdo->query("SELECT * FROM medicos where email = '$email' and senha_crip = '$senha' "); 
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);

	if(@count($dados) > 0){
		$_SESSION['id_user'] = $dados[0]['id'];
		$_SESSION['nivel_user'] = $dados[0]['nivel'];

		if($_SESSION['nivel_user'] == 'adm'){
			echo "<script language='javascript'> window.location='../Adm' </script>";
		}
		if($_SESSION['nivel_user'] == 'med'){
			echo "<script language='javascript'> window.location='../Medico' </script>";
		}
	}
	else{
		echo "<script language='javascript'> window.alert('Dados Incorretos!') </script>";
		echo "<script language='javascript'> window.location='../index.php' </script>";
	}
	
?>