<?php
if(isset($_GET["f"])):
		include "../util.class.php";
		Fluxo::db();
	endif;

	Fluxo::classe("upload");

	/*
		Cria a seção
	*/
		Secao::criar();

	/*
		Limpa o conteúdo dentro do POST
	*/
	if(isset($_POST)):
		$_POST = Util::sanitize($_POST);
	endif;

	$cf = new Upload;
	$cf->setProjetoID(Fluxo::idprojeto());
	$cf->setROOT(ROOT);

function enviarArquivo() {
	global $cf;
	global $erro;
	if(isset($_POST) && isset($_FILES["file"])):

		if( $cf->upload("file") ): echo $cf->src; endif;
	
	endif;
}

if(isset($_GET["f"])) {
	$act = $_GET["f"];
	$act();
}
?>