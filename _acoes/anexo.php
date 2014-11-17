<?php

	if(isset($_GET["f"])):
		include "../util.class.php";
		Fluxo::db();
	endif;

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

	Fluxo::classe("anexo");

	$anexo = new Anexo;
	$anexo->setProjetoID(Fluxo::idprojeto());

	function cadastrarAnexo() {
		global $anexo;
		
		$status = ($anexo->cadastrar($_POST)) ? "Anexo cadastrado com sucesso" : ERROR;
		Util::mensagem($status);
		Util::header("projeto.php?id=".Fluxo::idprojeto()."&editar=anexo");
	}
	function atualizarAnexo() {
		global $anexo;

		$id = $_POST["id"];
		$oldtipo = $_POST["oldtipo"];
		$tipo = $_POST["tipo"];
		$titulo = $_POST["titulo"];
		$html = $_POST["html"];
		$ordem = $_POST["ordem"];

		if( $anexo->atualizar($id,$titulo,$html,$tipo,$oldtipo,$ordem) ):
			Util::mensagem("Salvo com sucesso!");
		else:
			Util::mensagem("Ocorreu um erro desconhecido.<br> Tente novamente!");
		endif;

		Util::header("projeto.php?id=".Fluxo::idprojeto()."&editar=anexo");
	}
	function excluirAnexo() {
		global $anexo;
		$id = $_POST["id"];
		$tipo = $_POST["tipo"];
		$ordem = $_POST["ordem"];

		if($anexo->excluir($id,$ordem,$tipo)) :
			Util::mensagem("$tipo excluído com sucesso!");
		endif;
		Util::header("projeto.php?id=".Fluxo::idprojeto()."&editar=anexo");
	}

if(isset($_GET["f"])) {
	$act = $_GET["f"];
	$act();
}

?>