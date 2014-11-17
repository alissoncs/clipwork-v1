<?php
	if(isset($_GET["f"])):
		include "../util.class.php";
		Fluxo::db();
	endif;

	/*
		Cria a seção
	*/
		Secao::criar();

	/*
		Limpa o conteúdo dentro do POST
	*/
	if(isset($_POST)):
		$_POST = Util::sanitize($_POST);
	endif;

	Fluxo::classe("comentario");

	$comentario = new Comentario(Fluxo::idprojeto());

	$comentario->setUsuarioID(Fluxo::idprojeto());

	function adicionarComentario() {
		global $comentario;
		global $erro;
		$_POST["html"] = encodeEditor($_POST["html"]);
		if($comentario->novo($_POST)):
			$erro = "Comentário <strong>".$_POST["titulo"]."</strong> cadastrado com sucesso!";
		endif;
		echo $erro;
	}
	
	function listarComentario() {
		global $comentario;
		global $erro;

		$query = $comentario->listar();
		$c = 0;
		$num = $comentario->getNumComentarios();
		$classCount = ($num > 10) ? "mt-10" : "nt-10";

	if($query !== false && $num != 0):
		echo "<ul id='comment-list' class='ul-comments $classCount' data-type='comment-list'>";
	foreach($query as $linha):
		$autor = ($linha["idusuario"] == Secao::get("idusuario")) ? "Eu" : $linha["nomeusuario"] ;
	?>	
	<li class="<?php echo ($c==0) ? 'active':null; ?>"
		id="comentario-<?php echo $linha["id"]; ?>"
		data-id="<?php echo $linha["id"]; ?>" 
		data-usuario="<?php echo $linha["idusuario"]; ?>">
		<a aria-label="Comentário"
		href="#"
		data-id="<?php echo $linha["id"]; ?>">
		  <div class="">
			<author class="autor" aria-label="Autor: ">
				<i class="fa fa-comment-o"></i>
				<?php echo $autor; ?></author>
			<h6 class="legenda" aria-label="Título: "><?php echo $linha["titulo"]; ?></h6>
		  </div>
			   <time class="timestamp" aria-label="Data: ">
				<span class="data"><?php echo dataDe($linha["data"]); ?></span>
				<span class="hora"><?php echo ajustaHora($linha["hora"]); ?></span>
			   </time>
		</a>
	</li>

	<?php
		$c++;
	endforeach;
		echo "</ul>";
	else :
		echo "<span class='alert-message'>Nenhum comentário cadastrado</span>";
	endif;
	}

	function getComentario($limit=false) {
		global $comentario;
		global $erro;

		$id = (isset($_POST["id"])) ? $_POST["id"] : null ;

		$linha = $comentario->getComentario($id,$limit);
if($linha !== false):
		?>
	<div class="row">	
		
	<div class="line col-xs-5 pull-right">
			<div class="row">
			<?php if($linha["idusuario"] == Secao::get("idusuario")): ?>
				<div class="btn-group btn-group-sm pull-right">
					<button data-toggle="modal" data-target="#excluir-comentario" class="btn btn-default" title="Excluir">
						<i class="fa fa fa-trash"></i> Excluir
					</button>
				</div> <!-- btn-group -->
			<?php endif; ?>
			</div> <!-- row -->

<!-- modal -->
<?php if($linha["idusuario"] == Secao::get("idusuario")): ?>

<div class="modal fade" id="excluir-comentario" tabindex="-1" role="dialog" aria-labelledby="Excluir comentário" aria-hidden="true">
  <div class="modal-dialog">

    <form class="modal-content" rel="ajax" data-fn="comentario;excluirComentario">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
	        <h4 class="modal-title">Excluir comentário</h4>
	      </div>

	      <div class="modal-body">
	      	<p>Tem certeza que deseja excluir o comentário <strong>'<?php echo $linha["titulo"]; ?>'</strong> de <author><?php echo $linha["nomeusuario"]; ?></author>?</p>
			<input type="hidden" value="<?php echo $linha["id"]; ?>" name="id">
		  </div>

		  <div class="modal-footer">
		  		<span class="spinner small" arial-label="Carregando"></span>
		  		<button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
		  		<button type="submit" class="btn"><i class="fa fa-trash"></i>Excluir</button>
		  </div>
	</form>

</div>
</div>
<?php endif; ?>
<!-- modal -->

		</div>

		<div class="line col-xs-7">
			<i class="fa fa-comment"></i>
			Comentário de <strong class="article-title" id="comment-author">
				<?php echo $linha["nomeusuario"]; ?>
			</strong>
		</div>
		<div class="clearfix"></div>
		<hr>
	</div> <!-- row -->

	<div class="content comment">
	<div>
		<div class="title-message-container">
			<h2 id="comment-title" class="title-message"><?php echo $linha["titulo"]; ?></h2>
		</div>
		<div id="content-message" class="text-comment">
			<?php 
			$linha["html"] = mb_convert_encoding($linha["html"], "UTF-8", "HTML-ENTITIES");
			echo decodeEditor($linha["html"]); ?>
		</div>
	</div> <!-- comment.content -->

		<div class="leave-a-reply hide" id="reply">
			<form>
				<legend class="sr-only">Responder este comentário</legend>
				<div class="row">
					<label for="resposta">
						<span class="lar-title">Responder este comentário</span>
						<div class="textarea">
							<textarea name="resposta"></textarea>
						</div>
					</label>
				</div>
				<div class="row form-submit text-right">
					<span data-toggle="tooltip" title="Enviar resposta" data-placement="left">
						<button class="btn blue btn-sm" type="submit" aria-label="Enviar resposta">
							Responder
							<i class="fa fa-mail-reply"></i>
						</button>
					</span>
				</div>
			</form>
		</div>
	</div>
		<?php
endif;
	}

	function excluirComentario() {

		global $comentario;
		global $erro;
		if($comentario->excluir($_POST["id"])):
			$erro = "Comentário excluído com sucesso!";
		endif;
		echo $erro;
	}

	function responderComentario() {



	}


if(isset($_GET["f"])) {
	$act = $_GET["f"];
	$act();
}
?>
