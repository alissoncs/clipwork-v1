<div class="modal fade" id="nova-referencia" tabindex="-1" role="dialog" aria-labelledby="Cadastrar nova referência" aria-hidden="true">
  <div class="modal-dialog">
<form class="tipo-web modal-content" id="addreferencia" name="addreferencia" rel="ajax" data-fn="referencia;cadastrarReferencia">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
        <h4 class="modal-title">Nova referência</h4>
      </div>
<div class="modal-body">
<div class="row">
	<label class="row col-xs-12 tipo-referencia" title="Selecione o tipo de referência">
		<span>Tipo de referência: </span>
		<select name="tipo" class="mini toggle-tipo">
			<option value="web" selected>Página Web</option>
			<option value="livro">Livro</option>
			<option value="artigo">Artigo</option>
			<option value="outro">Outro</option>
		</select>
	</label>
</div>
<hr>
<!-- Comum em todos -->
<fieldset class="not-outro">
	<div class="row">
		<label class="col-xs-12" for="titulo">
			Título <span class="required" aria-label="Campo obrigatório"></span>
		<input type="text" name="titulo" class=""/>
		</label>
	</div>
	<hr>
	<div class="autores">
		
		<div class="row autor-1">
			<label class="col-xs-12 col-sm-6" for="nomeautor1">
				Nome do autor 1
				<input type="text" name="nomeautor1" class=""/>
			</label>
			<label class="col-xs-12 col-sm-6" for="sobrenomeautor1">
				Sobrenome do autor 1
				<input type="text" name="sobrenomeautor1" class=""/>
			</label>
		</div>

		<div class="row autor-2">
			<label class="col-xs-12 col-sm-6" for="nomeautor2">
				Nome do autor 2
				<input type="text" name="nomeautor2" class=""/>
			</label>
			<div class="col-xs-12 col-sm-6">
				<label for="sobrenomeautor2">
					Sobrenome do autor 2
					<input type="text" name="sobrenomeautor2" class=""/>
				</label>
				<label for="maisautores" class="row">
					<input type="checkbox" name="maisautores">
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
			<input type="text" name="url" title="URL/Link do site acessado"/>
		</label>
		<label for="dataacesso" class="col-xs-12 col-sm-6">
			Data de acesso: <span class="required" aria-label="Campo obrigatório"></span>
			<input type="date" name="dataacesso" title="Data em que o site foi acessado"/>
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
			<input autocomplete="off" type="text" name="editora" title="Editora responsável pela publicação do livro"/>
		</label>

		<label for="edicao" class="col-xs-12 col-sm-3">
			Num. Edição: 
			<input autocomplete="off" type="number" name="edicao" title="Número da edição do livro"/>
		</label>

		<label for="datalancamento" class="col-xs-12 col-sm-4">
			Data de lançamento: <span class="required" aria-label="Campo obrigatório"></span>
			<input autocomplete="off" type="date" name="datalancamento" title="Data de publicação do livro"/>
		</label>
	</div>
	<div class="row">
		<label for="local" class="col-sm-4 col-xs-12">
			Local: <span class="required" aria-label="Campo obrigatório"></span>
			<input type="text" name="local" title="Local da publicação do livro" placeholder="Santos - São Paulo"/>
		</label>

		<label for="paginalivro" class="col-sm-3 col-xs-12">
			Página:
			<input type="text" name="paginalivro" title="Página do livro"/>
		</label>

		<label for="traducao" class="col-sm-5 col-xs-12">
			Traduzido por: 
			<input type="text" name="traducao" title="Traduzido por"/>
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
			<input type="text" name="artigocaderno" title="Caderno" placeholder="Folha de São Paulo"/>
		</label>
	</div>
</fieldset>
<!-- somente artigo -->

<!-- somente outro -->
<fieldset class="only-outro">

<label class="textarea-summernote basic">
	Digite um texto personalizado:
	<textarea name="outro" class="summernote"></textarea>
</label>

</fieldset>
<!-- somente outro -->

</div> <!-- body -->
	<div class="modal-footer">
		<span class="spinner small" arial-label="Carregando"></span>
	   	<button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
	   	<input type="submit" class="btn green" value="Cadastrar"/>
	</div> <!-- modal-footer -->
</form>
  </div>
</div> <!-- modal -->