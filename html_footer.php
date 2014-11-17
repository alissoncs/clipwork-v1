<!-- Modal alerta -->

<div class="modal" tabindex="-1" role="dialog" aria-labelledby="Aviso:" id="alert-modal" aria-hidden="true">
  <div class="modal-dialog modal-sm">

  	<div class="modal-content">

  	<div class="modal-header">

  		<button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Fechar</span>
      </button>

  		<h4 class="modal-title"></h4>
  	</div>

    <div class="modal-body">

    </div>

    <div class="modal-footer">
	  		<button class="cancel green btn" data-dismiss="modal" aria-label="Fechar caixa de mensagem">
          <i class="fa fa-check"></i> <span>Ok</span>
        </button>
	  </div>

  </div>

   </div>

</div> <!-- modal -->

</section>
</div>


<script type="text/javascript" src="js/plugins/jquery.1.11.js" id="jquery-js"></script>
<script type="text/javascript" src="js/plugins/jquery.ui.js" id="nestable-js"></script>
<script type="text/javascript" src="js/plugins/bootstrap.js" id="bootstrap-js"></script>
<script type="text/javascript" src="js/plugins/tinymce/tinymce.min.js" id="tinymce-js"></script>
<script type="text/javascript" src="js/visual.js" id="visual-js"></script>
<script type="text/javascript" src="js/app.js" id="functions-js"></script>

<?php
  /*
    Mostra possíveis mensagem
  */
  Util::mensagem();
?>

<!--<?php
  $started_at = microtime(true);
  echo 'Tempo de carregamento: ' . (microtime(true) - $started_at); 
?>