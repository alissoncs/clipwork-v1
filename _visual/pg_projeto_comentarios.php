<?php 
	include "_acoes/comentario.php";
?>

<div class="row" id="app" data-id="">

<div class="col-xs-12 col-sm-4" id="app-list">
	<div class="line main-title">
		<h4>
			<i class="fa fa-comments-o"></i>
			<span>Comentários <strong><small>(<?php echo $info["numcoment"] ?>)</small></strong></span>
		</h4>
	</div>

	<div class="messages list">
		<div>
			<?php listarComentario(); ?>
		</div>
	</div>
	<?php 
		include VIEW."/modal_adicionar_comentario.php";
	?>

	<div class="clearfix">
		<span>
			<button data-toggle="modal" data-target="#novo-comentario" class="btn btn-sm green">
				<i class="fa fa-comment"></i>
				Novo comentário
			</button>
		</span>
	</div>

</div> <!-- comment-list --> 

<div class="col-xs-12 col-sm-8">
	
		<div class="spinner-content centered" style="display:none;" aria-hidden="true"><br>
			<span class="spinner" aria-hidden="true">Carregando mensagem</span>
		</div>

		<div id="app-content">
			<?php 
				getComentario(true);
			?>
		</div>

</div> <!-- row -->