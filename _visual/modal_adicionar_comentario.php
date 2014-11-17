<div class="modal fade" id="novo-comentario" tabindex="-1" role="dialog" aria-labelledby="Adicionar novo comentário" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <form class="modal-content" rel="ajax" data-fn="comentario;adicionarComentario">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title">Adicionar comentário</h4>
	      </div>

	<div class="modal-body">
	      	
		<p>
			As pessoas que estão colaborando com seu projeto irão visualizar seu comentário.
		</p>	

		<hr>
		<br>
		<div class="hide">
			<input type="hidden" value="<?php echo Secao::get("nome_sobrenome"); ?>" name="nomeusuario">
			<input type="hidden" value="<?php echo Secao::get("idusuario");; ?>" name="idusuario">
		</div>
		<div class="col-xs-12 center-block">
			<label for="titulo">
				Título do comentário:
				<input type="text" name="titulo" maxlength="30" title="Adicione um título para seu comentário" auto-complete="off" required>
			</label>
			<label for="html" class="textarea-summernote">
				Conteúdo:
				<textarea class="summernote" name="html"></textarea>
			</label>
		</div>


	</div> <!-- modal-body -->

		  <div class="modal-footer">
		  		<span class="spinner small" arial-label="Carregando"></span>
		  		<button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
		  		<button type="submit" class="btn green"><i class="fa fa-check"></i>Adicionar</button>
		  </div>

	</form>
</div>
</div>