<?php
	ob_start();

	include "util.class.php";

	Secao::criar();
	
	Fluxo::db();
	Fluxo::classe("usuario");

	/*
		Inclue o cabeçalho
	*/
	include ROOT."html_head.php";
	include ROOT."html_header.php";

	/*
		Verifica status de login do usuário
	*/
	if( !Secao::status() ) :  Util::header("index");  endif;

	/*
		Importa conteúdo da camada visual
	*/ 
	if(isset($_GET["pg"])): include(VIEW."pg_".$_GET["pg"].".php"); endif;
	if(empty($_GET["pg"])): include(VIEW."root_news.php"); endif;

	/*
		Inclue o rodapé
	*/
	include ROOT."html_footer.php";
	
	ob_end_flush();
?>

