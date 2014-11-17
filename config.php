<?php


// Define diretório base PHP
	if(!defined("ROOT")): 
		define("ROOT", dirname(__FILE__)."/");
	endif;

// Diretório para HEADERS e redirects
	if(!defined("URL")): 
		define("URL", "http://".$_SERVER['SERVER_NAME']."/".basename(__DIR__)."/");
	endif;

// DIRETORIOS DO MVC
if(defined("ROOT")):
	if(!defined("VIEW")):
		define("VIEW",ROOT."_visual/");
	endif;
	if(!defined("CONTROL")):
		define("CONTROL",ROOT."_acoes/");
	endif;
	if(!defined("MODEL")):
		define("MODEL",ROOT."_classes/");
	endif;
endif;


// DIRETÓRIO CLIENTE
if(!defined("CLIENTE") && defined("ROOT")):
	define("CLIENTE",ROOT."cliente/");
endif;



$erro = "Ocorreu um erro desconhecido, tente novamente";

if(!defined("ERROR")):
	define("ERROR",$erro);
endif;

?>