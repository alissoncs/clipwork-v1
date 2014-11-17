<div class="modal fade" data-modal="excluir-topico" tabindex="-1" role="dialog" aria-labelledby="Excluir tópico" aria-hidden="true">
  <div class="modal-dialog">

    <form class="modal-content" rel="ajax" data-fn="topico;excluirTopico">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
	        <h4 class="modal-title">Excluir tópico</h4>
	      </div>

	      <div class="modal-body">
	      	<p>Tem certeza que deseja excluir o tópico selecionado?</p>
			<input type="hidden" class="hide id-topico" value="" name="id" >
		  </div>

		  <div class="modal-footer">
		  		<span class="spinner small" arial-label="Carregando"></span>
		  		<button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
		  		<button type="submit" class="btn"><i class="fa fa-trash"></i>Excluir</button>
		  </div>

	</form>
</div>
</div>