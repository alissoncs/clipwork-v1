<div class="modal fade" id="nova-nota" tabindex="-1" role="dialog" aria-labelledby="Cadastrar nova nota" aria-hidden="true">
  <div class="modal-dialog">

    <form class="modal-content" rel="ajax" data-fn="notas;cadastrarNotas">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title">Nova anotação</h4>
	      </div>

	      <div class="modal-body">
			<label for="assunto">
				Assunto
				<input type="text" autocomplete="off" name="assunto" required/></label>
			<label for="texto" class="textarea-summernote">
				Conteúdo
				<textarea name="texto" class="summernote"></textarea></label>
		  </div>

		  <div class="modal-footer">
		  	    <span class="spinner small" arial-label="Carregando"></span>
		  		<button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
		  		<input type="submit" class="btn green"value="Adicionar"/>
		  </div>

	</form>
</div>
</div>