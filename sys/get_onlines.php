<?php
	
	include_once("../pdo/include.php");
	$chat = new meuchat($pdo);
	$chat->get_onlines($_GET['setor']);

?>
	
