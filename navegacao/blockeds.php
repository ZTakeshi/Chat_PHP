<?php

// Bloqueia o acesso a área do usuário
session_start();

if (!isset($_SESSION['usuario']))
{

	header("Location: login");
	exit;

}

?> 