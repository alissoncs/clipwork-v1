<?php 
	ob_start();	

	include "util.class.php";

	/*
		Cria a seção
	*/
	Secao::criar();

	Fluxo::db();
	Fluxo::classe("projeto");
	Fluxo::classe("usuario");
	
	/*
		Verifica se possui o parâmetro ID
	*/
	if(empty($_GET["id"])): Util::header("linha"); exit; endif;

	/*
		Instancia a classe projeto
	*/
	$projeto = new Projeto;
		
		/*
			Seta ID do usuário apartir da $_SESSION;
		*/

		$projeto->setIDUsuario(Secao::get("idusuario"));

		/*
			Seta o ID do usuário
		*/
		define("ID_PROJETO",$_GET["id"]);

		$projeto->setID(ID_PROJETO);

		/*
			Define projetoURL
		*/
			define("PROJETO_URL","projeto.php?id=".ID_PROJETO);

		/*
			Variável básica de $info -> 
		*/
		$info = $projeto->getInfo();

		/*
			Verifica se usuário pode acesar o projeto -->
		*/
		$projeto->autenticar();


		/*
			Carrega array de permissao (classe Projeto) -->
		*/
		$GLOBALS['permissao'] = $projeto->getPermissao();

		$GLOBALS['at'] = $GLOBALS['permissao']['all']; // [a]cesso [t]otal

		/*
			Redireciona caso o usuário não possa acessar o diretório atual
		*/
		$actual = $projeto->getDefault( isset($_GET['editar']) ? $_GET['editar'] : null  );
		
		if( $GLOBALS['at'] == false
			&& isset($GLOBALS['permissao'][$actual])
			&& $GLOBALS['permissao'][$actual] == 0
		):
			Util::mensagem("Você não tem permissão para acessar essa área");
			Util::header("projeto.php?id=".Fluxo::idprojeto());
		endif;
		
	/*
		Inclue o cabeçalho
	*/
	include ROOT."html_head.php";
	include ROOT."html_header.php";
	
	// Classe para caso o usuário tenha ou não acesso total
	$classeAcesso = ($GLOBALS['at'] == true) ? "total" : "acompanhando" ;

	echo "<div class=\"container-fluid clear-padd context-project {$classeAcesso}\">";
	
		/*
		Importa a classe menu projeto
		*/

	Fluxo::classe("menu.projeto");

	$menuprojeto = new MenuProjeto(ID_PROJETO);
	$menuprojeto->current($actual);

	/*
		Seta todos os itens do menu principal
	*/
	if($GLOBALS['at'] == true) $menuprojeto->item("Identif.","capa");
	$menuprojeto->item("Tópico","topicos","file-text-o");
	$menuprojeto->item("Referências","referencias");
	$menuprojeto->item("Anexos","anexo","paperclip");
	$menuprojeto->item("Comentários","comentarios","comments-o");
	$menuprojeto->item("Notas","notas");
	$menuprojeto->item("PDF","pdf","file-pdf-o","Gerar arquivo PDF");

	include(VIEW."pg_projeto.header.php");
	
	/*
		Inclui conteúdo
	*/
		$includename = VIEW."/pg_projeto_".$actual.".php";
			

		if( file_exists($includename) ) :
			echo "<div id='main' role='main' class='context-project-area context-{$actual}' data-permissao='{$classeAcesso}' data-area='".$actual."'>";
			
			echo "<input type='hidden' name='idprojeto' id='idprojeto' value='".ID_PROJETO."' class='hide' disabled/>";
			
			echo "<div class='row inner'>";
				include $includename;
			echo "</div></div>";
		else:
			echo "Parte não encontrada";
		endif;

?>

	</div> <!-- context-project -->

<?php
	
	include ROOT."html_footer.php";
	ob_end_flush();
?>