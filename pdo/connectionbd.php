<?php
	
	// Conexão com o banco de dados mychat
	date_default_timezone_set('america/sao_paulo');
	
	$conn = array("localhost", "root", "", "mychat");

	try{

		$pdo = new PDO("mysql:host=$conn[0]; dbname=$conn[3];", $conn[1], $conn[2]);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}catch(PDOException $e)
	{
	
		echo "Erro ao conectar-se: ".$e->getMessage();
	
	}
?>