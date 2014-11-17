<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" id="renomear-topico" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content no-clear" rel="ajax" data-fn="topico;retitularTopico">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Renomear tópico</h4>
      </div>

<div class="modal-body">
	<label for="titulo">
		Editar título do tópico
    <input type="hidden" name="id" class="id-topico" autocomplete="off"/>
		<input type="text" name="titulo" class="topico-titulo" autocomplete="off" value=""/>
	</label>
 </div><!-- modal-body -->

<div class="modal-footer">
    <span class="spinner small" arial-label="Carregando"></span>
      	<button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
      	<input type="submit" class="btn" value="Salvar"/>
</div> <!-- modal-footer -->

</form>
</div>
</div> <!-- modal -->