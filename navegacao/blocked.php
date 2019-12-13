<?php

// Bloqueia o acesso a área do supervisor
session_start();

if (!isset($_SESSION['admin']))
{

	header("Location: login");
	exit;

}

?> 
