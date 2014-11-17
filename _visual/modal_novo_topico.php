
<div class="modal fade" data-modal="novotopico" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" rel="ajax" data-fn="topico;cadastrarTopico">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
        <h4 class="modal-title">Novo tópico</h4>
      </div>
<div class="modal-body">
	<label for="titulo">
		Título do tópico
		<input type="text" name="titulo" value=""/>
	</label>
 </div><!-- modal-body -->

<div class="modal-footer">
    <div class="hide">
      <input type="hidden" class="hide" name="nivel" value="null"/>
      <input type="hidden" class="hide" name="idpai" value="null"/>
    </div>

    <span class="spinner small" arial-label="Carregando" aria-hidden="true"></span>
    <button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
    <input type="submit" class="btn green" value="Cadastrar"/>

</div> <!-- modal-footer -->

</form>
</div>
</div> <!-- modal -->

