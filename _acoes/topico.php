<?php

	if(isset($_GET["f"])):
		include "../util.class.php";
		Fluxo::db();

		/*
			Autentica usuário com o projeto
		*/
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

	Fluxo::classe("topico");

	$topico = new Topico;

	$topico->setProjeto(Fluxo::idprojeto());

	function forListar($nivel,$idpai,$prefixo=false) {
		$prefixo .= (!$prefixo) ? "" : ".";
		if($nivel == 1) {
			echo "<ul class='sections-list' tabindex='2'>";
		}else {
			echo "<ul>";
		}
		
		global $topico;
		$l = $topico->listar($nivel,$idpai);
		foreach ($l as $linha) {

			$sub = $topico->existe( $linha["nivel"] + 1, $linha["id"]);
			$varprefixo = $prefixo.$linha["ordem"]." ";
			$class = ($sub) ? " has-sub " : "";
			$tituloReduzido = ( strlen($linha["titulo"]) > 20 ) ? "<small>".$varprefixo.$linha["titulo"]."</small>" : $varprefixo.$linha["titulo"] ;
			?>

			<li class="topico nivel-<?php echo $linha["nivel"].$class; ?> topicoid-<?php echo $linha["id"]?>"
				id="topicoid-<?php echo $linha["id"]?>"
				data-nivel="<?php echo $linha["nivel"]?>"
				data-ordem="<?php echo $linha["ordem"]?>"
				data-id="<?php echo $linha["id"]?>"
				aria-label="Tópico: <?php echo $varprefixo; echo $linha["titulo"]; ?>"
				role="menuitem">
				<div class="hover-space">
					<span class="handle" data-placement="right"
				data-toggle="tooltip"
				title="Reordenar">
						<i class="fa fa-sort"></i>
					</span>
					<a href="#" role="button" aria-label="Editar este tópico">
						<?php if ($linha["nivel"] == 1) { echo "<strong>"; }?>
						<?php echo $varprefixo; echo $linha["titulo"]; ?>
						<?php if ($linha["nivel"] == 1) { echo "</strong>"; }?>
					</a>
					
				<button class="btn-subsection" 
				role="button"
				data-target="#modal-topico-<?php echo $linha["id"]?>" 
				data-toggle="modal" 
				aria-label="Adicionar subtópico">
					<i class="fa fa-plus-square"></i>
					<span class="sr-only">Adicionar subtópico</span>
				</button>

				</div>

				<div class="topico-detalhes hide" data-titulo="<?php echo $linha["titulo"]; ?>" data-id="<?php echo $linha["id"]?>" data-hora="<?php echo $linha["hora"]?>" data-data="<?php echo $linha["data"]?>" aria-hidden="true">
				</div>

				<div class="modal fade" tabindex="-1" id="modal-topico-<?php echo $linha["id"]?>" role="dialog" aria-labelledby="" aria-hidden="true">
				  <div class="modal-dialog">
				    <form class="modal-content" rel="ajax" data-fn="topico;cadastrarTopico">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <h4 class="modal-title">Novo subtópico</h4>
				      </div>
				<div class="modal-body">
					<label for="titulo">
						Subtópico para: <strong><?php echo $varprefixo; ?> <?php echo $linha["titulo"]; ?></strong>
						<input type="text" name="titulo" value=""/>
				      <input type="hidden" class="hide" name="nivel" value="<?php echo $linha["nivel"]?>"/>
				      <input type="hidden" class="hide" name="idpai" value="<?php echo $linha["id"]?>"/>
					</label>
				 </div><!-- modal-body -->

				<div class="modal-footer row">
						<span class="spinner small" arial-label="Carregando"></span>
				      	<button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
				      	<input type="submit" class="btn green" value="Cadastrar"/>
				</div> <!-- modal-footer -->

				</form>
				</div>
				</div> <!-- modal -->

			<?php

			if( $sub ) {
				forListar($linha["nivel"] + 1, $linha["id"], $prefixo.$linha["ordem"] );
			}

			echo "</li>";
		}

		echo "</ul>";
	}

	function listarTopico() {
		global $topico;
		global $touch;
		if($topico->existe(1)) {
			forListar(1,null);
		}else {
			echo "<span class='alert-message'>Nenhum tópico cadastrado</span>";
		}
	}
	function cadastrarTopico() {
		global $topico;
		global $erro;

		$titulo = $_POST["titulo"];
		$idpai = $_POST["idpai"];
		$nivel = $_POST["nivel"];

		if(isset($titulo)) {
			if($topico->cadastrar($titulo,$nivel,$idpai)){
				$erro = "'$titulo' cadastrado com sucesso!";
			}
			// echo $topico->cadastrar($titulo,$nivel,$idpai);
		}
		echo $erro;
	}
	function atualizarTopico() {
		global $topico;

		$id = $_POST["id"];
		$html = $_POST["html"];
		$html = encodeEditor($html);		
		if( $topico->atualizar($id,$html) ) {
			$x = $topico->dataSalvamento($id);
			echo json_encode($x);
		}	
	}	
	function pegarHtml() {
		global $topico;
		$id = $_POST["id"];
		$x = $topico->pegarHtml($id);
		$x["html"] = html_entity_decode($x["html"]);
		$x["html"] = ($x["html"] == null) ? "Comece digitando" : $x["html"] ;
		$x["data"] = dataDe($x["data"]);
		echo json_encode($x);
	}

	function retitularTopico() {
		global $topico;
		$id = $_POST["id"];
		$titulo = $_POST["titulo"];
		if($topico->renomear($id,$titulo)) {
			$erro = "Renomeado com sucesso!";
		}
		echo $erro;
	}

	function excluirTopico() {
		global $topico;
		$id = $_POST["id"];
		if(isset($id)):
			if($topico->excluir($id)) :
				$erro = "Tópico excluído com sucesso!";
			endif;
		endif;
		echo $erro;
	}

	function reordenarTopico() {
		global $topico;
		$ordem = $_POST["ordem"];
		if($topico->reordenar($ordem)) {
			$erro = "Reordenado com sucesso";
		}
		echo $erro;
	}

	function testeProjeto() {
		echo $_POST["idprojeto"];
	}

if(isset($_GET["f"])) {
	$act = $_GET["f"];
	$act();
}
?>