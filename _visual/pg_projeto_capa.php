<div class="container-fluid padd all">

<header class="master row">
	<h1>Detalhes :: identificação</h1>

</header>

<div class="basic-editing col-md-10 col-sm-12 col-xs-12">
<form action="_acoes/projeto.php?f=atualizarDados" method="post" id="edit-details" class="col-xs-12 clear-padd">
<fieldset>
		<legend class="hide">Informações básicas</legend>
		<input type="hidden" name="idprojeto" value="<?php echo ID_PROJETO; ?>"/>
<div class="row">
	<label for="titulo" class="col-xs-12 col-sm-6">
		Título completo:
	<?php
		$fetchtitle = ($info["titulocompleto"] == null) ? $info['nome'] : $info["titulocompleto"];
	?>
		<input name="titulocompleto" type="text" value="<?php echo $fetchtitle; ?>" required/>
	</label>

	<label for="subtitulo" class="col-xs-12 col-sm-6">
		Subtítulo:
		<input name="subtitulo" type="text" value="<?php echo $info["subtitulo"]; ?>"/>
	</label>
</div>
<div class="row">
	<label for="entidade" class="col-xs-12 col-sm-6">
		Instituição:
		<input name="entidade" type="text" value="<?php echo $info["entidade"]; ?>"/>
	</label>

	<label for="curso" class="col-xs-12 col-sm-6">
		Curso:
		<input name="curso" type="text" value="<?php echo $info["curso"]; ?>"/>
	</label>
</div>
<label for="autores" class="col-xs-12">
	Autore(s):
	
	<?php
		$fetchAutores = ($info["autores"] == null) ? Secao::get("nome_sobrenome").",".$info['integrantes'] : $info["autores"];
	?>

	<div class="input-group">
	<div class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Autores"><span class="fa fa-group"></span></div>
		<input name="autores" type="text" value="<?php echo $fetchAutores; ?>" required/>
	</div>

	<label class="small">Se for mais de um, separá-los por virgula</label>
</label>

<div class="row">
	<label for="orientador" class="col-xs-12 col-sm-6">
		Orientador:
		<input name="orientador" type="text" value="<?php echo $info["orientador"]; ?>"/>
	</label>

	<label for="coorientador" class="col-xs-12 col-sm-6">
		Coorientador:
		<input name="coorientador" type="text" value="<?php echo $info["coorientador"]; ?>"/>
	</label>
</div>

<div class="row">
	<label for="cidade" class="col-xs-12 col-sm-6">
		Cidade:
		<input name="cidade" type="text" value="<?php echo $info["cidade"]; ?>"/>
	</label>

	<label for="data" class="col-xs-12 col-sm-6">
		Data:
		<div class="input-group">
		<div class="input-group-addon" data-toggle="tooltip" title="Data de entrega"><span class="fa fa-calendar-o"></span></div>
			<input name="data" type="date" value="<?php echo $info["data"]; ?>"/>
		</div>
	</label>
</div>

<div class="natureza">
	<hr>
	<label for="natureza" class="textarea-summernote">
		Natureza (presente na folha de rosto)
		<textarea name="natureza" class="summernote"><?php echo $info["natureza"]; ?></textarea>
	</label>

<label for="resumo" class="textarea-summernote">
	<hr>
	<h5>Resumo</h5>
	<textarea name="resumo" class="summernote"><?php echo $info['resumo']; ?> </textarea>
</label>


</div>

</fieldset>

<div class="row submit-area col-xs-12">
	<div class="hs clearfix"></div>

	<div class="row">
		<div class="col-xs-12 col-md-3 pull-right">
			<input class="btn green big" type="submit" value="Salvar"/>
		</div>
	</div>
</div>

</form>
</div> <!-- basic-editing -->

</div>