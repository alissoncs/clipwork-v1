<?php
 	if(isset($_GET["f"])):
		include "../util.class.php";
		Fluxo::db();
	endif;

	/*
		Limpa o conteúdo dentro do POST
	*/
	if(isset($_POST)):
		$_POST = Util::sanitize($_POST);
	endif;

	/*
		Cria a seção
	*/
		Secao::criar();


	if ($_FILES['file']['name']) {	
		$nome = $_FILES['file']['name'];
		$dir = dirname(dirname(__FILE__))."/cliente/imagens/";
		$dirproj = $dir.ID_PROJETO."/";

		if(!is_dir($dirproj)) :
			mkdir($dirproj,0777,true);
		endif;

		$uploadstatus = move_uploaded_file($_FILES["file"]["tmp_name"], $dirproj.$nome);
		echo $dirproj.$nome;
    }
?>