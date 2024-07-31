<?php

$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'clinica_sicuro';

// $servidor = 'localhost';
// $usuario = 'univ9223_Main_autoInove';
// $senha = 'Autoinove123@';
// $banco = 'univ9223_Auto_Inove';

date_default_timezone_set('America/Sao_Paulo');

try {
	$pdo = new PDO("mysql:dbname=$banco;host=$servidor;charset=utf8", "$usuario", "$senha");

	//CONEXAO MYSQLI PARA O BACKUP
	$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

} catch (Exception $e) {
	echo "Erro ao conectar com o banco de dados! " . $e;
}

?>