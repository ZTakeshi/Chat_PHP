<?php
	
	include_once("../pdo/include.php");
	$chat = new meuchat($pdo);	
	echo $chat->insere_mensagem();

?>