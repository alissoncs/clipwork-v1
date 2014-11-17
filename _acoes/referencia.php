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

	Fluxo::classe("referencia");

	$referencia = new Referencia;
	$referencia->setProjetoID(Fluxo::idprojeto());

	$erro = "Ocorreu algum erro. Tente novamente";

function cadastrarReferencia() {
	global $referencia;
	global $erro;

	$tipo = $_POST["tipo"];
	$_POST["html"] = (isset($_POST["html"])) ? encodeEditor($_POST["html"]) : null;
	$referencia->setTipo($tipo);
	$erro = ( $referencia->cadastrar($_POST) ) ? "Referência '".$_POST["titulo"]."' cadastrada com sucesso!" : $erro;
	echo $erro;
}
function editarReferencia() {
	global $referencia;
	global $erro;

	$tipo = $_POST["tipo"];
	$referencia->setTipo($tipo);
	$_POST["html"] = (isset($_POST["html"])) ? encodeEditor($_POST["html"]) : false;
	// echo $referencia->atualizar($_POST);
	if ($referencia->atualizar($_POST)) : $erro = "Atualizado com sucesso!"; endif;
	echo $erro;
}
function removerReferencia() {
	global $referencia;
	global $erro;
	$id = $_POST["id"];
	if($referencia->remover($id)) {
		$erro = "Referência removida com sucesso";
	}	
	echo $erro;
}
function listarReferencia($tipo=null) {
	global $referencia;

	$ref = $referencia->listar();
	if( $ref ) {
		echo "<ul class='reference-list listagem'>";
	foreach($ref as $linha) {
		$tipo = $linha["tipo"];
		$titulo = ( $linha["titulo"] != null) ? $linha["titulo"] : $linha["url"];
		$titulo = ($tipo == "outro") ? strip_tags($linha["html"]) : $titulo;
		$titulo = reduzirTexto($titulo,30);
	?>
		<li class="row referencia-<?php echo $linha["id"]." "; echo $tipo; ?>"
			data-id="<?php echo $linha["id"]; ?>"
			data-tipo="<?php echo $tipo; ?>">
				<small class="legend"><?php echo $tipo; ?></small>
				<span class="title" role="button" data-target="#modal-referencia-<?php echo $linha["id"]; ?>" data-toggle="modal"><?php echo $titulo; ?></span>
				
				<button type="button" class="btn btn-default" aria-label="Editar os detalhes de <?php echo $titulo; ?>" data-target="#modal-referencia-<?php echo $linha["id"]; ?>" data-toggle="modal">
					<span class="fa fa-edit"></span>
					<span class="">Edição</span>
				</button>

<div class="modal fade" id="modal-referencia-<?php echo $linha["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="Editar referência" aria-hidden="true">
  <div class="modal-dialog">
  <form class="modal-content not-clear tipo-<?php echo $linha["tipo"]; ?>" rel="ajax" data-fn="referencia;editarReferencia">
	  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Editar referência "<?php echo $titulo; ?>"</h4>
      </div>
      <input autocomplete="off" type="hidden" class="hide" name="id" value="<?php echo $linha["id"]; ?>"/>

<div class="modal-body">
<div class="row">
	<label class="row col-xs-12 tipo-referencia" title="Selecione o tipo de referência">
		<span>Tipo de referência: </span>
		<select name="tipo" class="mini toggle-tipo">
			<option value="web" <?php if ($tipo=="web") : echo "selected"; endif; ?>>Página Web</option>
			<option value="livro" <?php if ($tipo=="livro") : echo "selected"; endif; ?>>Livro</option>
			<option value="artigo" <?php if ($tipo=="artigo") : echo "selected"; endif; ?>>Artigo</option>
			<option value="outro" <?php if ($tipo=="outro") : echo "selected"; endif; ?>>Outro</option>
		</select>
	</label>
</div>
<hr>
<!-- Comum em todos -->
<fieldset class="not-outro">
	<div class="row">
		<label class="col-xs-12" for="titulo">
			Título <span class="required" aria-label="Campo obrigatório"></span>
		<input autocomplete="off" type="text" name="titulo" class="" value="<?php echo $linha["titulo"]; ?>"/>
		</label>
	</div>
	<hr>
	<div class="autores">
		
		<div class="row autor-1">
			<label class="col-xs-12 col-sm-6" for="nomeautor1">
				Nome do autor 1
				<input autocomplete="off" type="text" name="nomeautor1" class="" value="<?php echo $linha["nomeautor1"]; ?>"/>
			</label>
			<label class="col-xs-12 col-sm-6" for="sobrenomeautor1">
				Sobrenome do autor 1
				<input autocomplete="off" type="text" name="sobrenomeautor1" class="" value="<?php echo $linha["sobrenomeautor1"]; ?>"/>
			</label>
		</div>

		<div class="row autor-2">
			<label class="col-xs-12 col-sm-6" for="nomeautor2">
				Nome do autor 2
				<input autocomplete="off" type="text" name="nomeautor2" class="" value="<?php echo $linha["nomeautor2"]; ?>"/>
			</label>
			<div class="col-xs-12 col-sm-6">
				<label for="sobrenomeautor2">
					Sobrenome do autor 2
					<input autocomplete="off" type="text" name="sobrenomeautor2" class="" value="<?php echo $linha["sobrenomeautor2"]; ?>"/>
				</label>
				<label for="maisautores" class="row">
					<?php $ch = ($linha["maisautores"] == 1) ? "checked": ""; ?>
					<input autocomplete="off" type="checkbox" name="maisautores" <?php echo $ch; ?>>
					Possui mais autores
				</label>
			</div>	
		</div>
		<hr>
	</div> <!-- autores -->
</fieldset> <!-- informações basicas -->

<!-- somente web -->
<fieldset class="only-web">
	<legend class="hide">Dados para página web</legend>
	<div class="row">
		<label for="url" class="col-xs-12 col-sm-6">
			URL: <span class="required" aria-label="Campo obrigatório"></span>
			<input autocomplete="off" type="text" name="url" title="URL/Link do site acessado" value="<?php echo $linha["url"]; ?>"/>
		</label>
		<label for="dataacesso" class="col-xs-12 col-sm-6">
			Data de acesso: <span class="required" aria-label="Campo obrigatório"></span>
			<input autocomplete="off" type="date" name="dataacesso" title="Data em que o site foi acessado" value="<?php echo $linha["dataacesso"]; ?>"/>
		</label>
	</div>
</fieldset>
<!-- somente web -->

<!-- somente livro -->
<fieldset class="only-livro only-artigo">
	<legend class="hide">Dados para livro/artigo</legend>
	<div class="row">
		<label for="editora" class="col-xs-12 col-sm-5">
			Editora: <span class="required" aria-label="Campo obrigatório"></span>
			<input autocomplete="off" type="text" name="editora" title="Editora responsável pela publicação do livro" value="<?php echo $linha["editora"]; ?>"/>
		</label>

		<label for="edicao" class="col-xs-12 col-sm-3">
			Num. Edição: 
			<input autocomplete="off" type="number" name="edicao" title="Número da edição do livro" value="<?php echo $linha["edicao"]; ?>"/>
		</label>

		<label for="datalancamento" class="col-xs-12 col-sm-4">
			Data de lançamento: <span class="required" aria-label="Campo obrigatório"></span>
			<input autocomplete="off" type="date" name="datalancamento" title="Data de publicação do livro" value="<?php echo $linha["datalancamento"]; ?>"/>
		</label>
	</div>
	<div class="row">
		<label for="local" class="col-sm-4 col-xs-12">
			Local: <span class="required" aria-label="Campo obrigatório"></span>
			<input autocomplete="off" type="text" name="local" title="Local da publicação do livro" placeholder="Santos - São Paulo" value="<?php echo $linha["local"]; ?>"/>
		</label>

		<label for="paginalivro" class="col-sm-3 col-xs-12">
			Página:
			<input autocomplete="off" type="text" name="paginalivro" title="Página do livro" value="<?php echo $linha["paginalivro"]; ?>"/>
		</label>

		<label for="traducao" class="col-sm-5 col-xs-12">
			Traduzido por: 
			<input autocomplete="off" type="text" name="traducao" title="Traduzido por" value="<?php echo $linha["traducao"]; ?>"/>
		</label>
	</div>
</fieldset>
<!-- somente livro -->

<!-- somente artigo -->
<fieldset class="only-artigo">
	<legend class="hide">Dados para artigo</legend>
	<div class="row col-xs-12">
		<label for="artigocaderno">
			Caderno (dentro do artigo):
			<input autocomplete="off" type="text" name="artigocaderno" title="Caderno" placeholder="Folha de São Paulo" value="<?php echo $linha["artigocaderno"]; ?>"/>
		</label>
	</div>
</fieldset>
<!-- somente artigo -->

<!-- somente outro -->
<fieldset class="only-outro">

<label class="textarea-summernote basic">
	Digite um texto personalizado:
	<textarea name="outro" class="summernote"><?php echo $linha["html"]; ?></textarea>
</label>

</fieldset>
<!-- somente outro -->

</div> <!-- body -->
	<div class="modal-footer">
		<div class="col-xs-4 text-left">
			<button class="delete btn" data-type="ajax" data-fn="referencia;removerReferencia" data-post="id=<?php echo $linha["id"]; ?>">
				<i class="fa fa-trash"></i>Excluir</button>
		</div>
		<div class="col-xs-8">
			<span class="spinner small" arial-label="Carregando"></span>
	   		<button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
	   		<input autocomplete="off" type="submit" class="btn blue" value="Salvar alterações"/>
	   	</div>
	</div> <!-- modal-footer -->
</form>
</div>
</div> <!-- End modal -->

		</li> <!-- li -->
	<?php
	}
		echo "</ul>";
	}else {
		echo "<span class='alert-message'>Nenhuma referência cadastrada</span>";
	}
}
 
if(isset($_GET["f"])) {
	$act = $_GET["f"];
	$act();
}

?>