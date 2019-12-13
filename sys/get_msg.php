<?php
	
	include_once("../pdo/include.php");
	$chat = new meuchat($pdo);
	$chat->get_msg($_GET['setor']);

?>