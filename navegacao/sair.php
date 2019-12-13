<?php

	// Encerra o login do usuário no sistema
	require_once('navegacao/blockeds.php');	
	session_destroy();
	$chat = new meuchat($pdo);
	$chat->redirect('login');
	$chat->alerta('danger', 'Saindo', false);

?>