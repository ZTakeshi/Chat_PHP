<?php

	include_once("../pdo/include.php");
	$chat = new meuchat($pdo);
	$usuario = (isset($_SESSION['usuario']) ? $_SESSION['usuario'] : false);	
	echo $chat->pega_chats($usuario);

?>
	
