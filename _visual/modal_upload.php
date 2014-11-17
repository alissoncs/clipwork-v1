<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="Upload de arquivo" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="send-file" enctype="multipart/form-data" action="_acoes/upload.php?f=enviarArquivo" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
	        <h4 class="modal-title">Upload de arquivo</h4>
	      </div>

	      <div class="modal-body">
	      	<input type="hidden" name="send" value="true"/>
	      	<input type="hidden" name="idprojeto" value="<?php echo ID_PROJETO; ?>"/>

			<label for="file">
				Enviar arquivo:
				<input name="file" id="file-input" type="file">
			</label>

			<label for="descricao">
				Descrição:
				<input type="text" id="file-descricao" name="descricao">
			</label>

		  </div>

		  <div class="modal-footer">
		  		<span class="spinner small" arial-label="Carregando"></span>
		  		<button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
		  		<button type="submit" class="btn"><i class="fa fa-upload"></i>Enviar arquivo</button>
		  </div>
	</form>
</div>
</div> <!-- modal -->