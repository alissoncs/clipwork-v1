<?php

	if(isset($_GET["f"])):
	include "../util.class.php";
	Fluxo::db();
	endif;

	/*
		Cria a seção
	*/
		Secao::criar();

	include("../_mpdf/mpdf.class.php");
	function gerarPdfTrabalho() {

		Fluxo::classe("gerartrabalho");

		$pdf = new GerarTrabalho;

		$pdf->setProjetoID(Fluxo::idprojeto());


		// Seta parâmetros de configuração
		$pdf->setConfig($_POST);

		//print_r($pdf->getConfig());

		$pdf->__criar();

	}
	function gerarPdfNotas() {
		/**
		 * Importa as classes necessárias
		 */
		Fluxo::classe("gerartrabalho");
		Fluxo::classe("gerarnotas");

		$gerarnotas = new GerarNotas;
		
		$gerarnotas->setProjetoID(Fluxo::idprojeto());

		$gerarnotas->setConfig($_POST);

		$gerarnotas->_criar();


	}

	/*
		Limpa o conteúdo dentro do POST
	*/
	if(isset($_POST)):
		$_POST = Util::sanitize($_POST);
	endif;

	

if(isset($_GET["f"])) {
	$act = $_GET["f"];
	$act();
}


?>