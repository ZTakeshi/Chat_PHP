<?php  

	session_destroy();
	$chat = new meuchat($pdo);
	$chat->redirect('login');
	echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=login'>";

?>