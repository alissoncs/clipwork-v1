<div class="col-xs-12 col-md-5">

<div id="referencia" data-load="ajax">
	<?php
		include "_acoes/referencia.php";
		listarReferencia();
	?>
	</div>
<div class="row section-footer">
	<button class="btn" data-toggle="modal" data-target="#nova-referencia" title="Cadastrar referência">Nova referência</button>
</div>
<?php 
	include dirname(__FILE__)."/modal_referencias.php";
?>

</div>