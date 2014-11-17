<?php
	include "util.class.php";
	
	Fluxo::db();
	Fluxo::classe("usuario");
	Usuario::sair();
?>