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

	Fluxo::classe("notas");

	$notas = new Notas(Secao::get("idusuario"),Fluxo::idprojeto());

function listarNotas() {
	global $notas;
	$notas = $notas->listar();
	if($notas) {
	echo "<ul class='notes-list row'>";
	foreach ( $notas as $s) {
		$s["ativo"] = ($s["ativo"]==1) ? true : false;
	?>

	  	<li class="nota col-xs-12 col-lg-3 col-md-6 col-sm-6<?php if(!$s["ativo"]): echo " out"; endif; ?>"
	  		id="notaid-<?php echo $s['id']; ?>"
	  		data-id="<?php echo $s['id']; ?>">
	  		<div role='button' data-toggle="modal" data-target="#nota-detalhesid-<?php echo $s['id']; ?>" class="content">
	  			<h4 class="title"><?php echo $s['assunto']; ?></h4>
	  			<author class="author hide">Por: <?php echo $s['usuarioautor']; ?></author>
	  			<time class='timestamp'>
	  				<span class='data'>
	  					<strong class="sr-only">Data:</strong> <?php echo dataDe($s['data']); ?>
	  				</span>
	  				<span class='time'>
	  					<strong class="sr-only">Horário:</strong> <?php echo $s['hora']; ?>
	  				</span>
	  			</time>
	  			<?php
	  				$text = decodeEditor($s['texto']);
	  				$textCount = strlen(strip_tags(str_replace(" ", "", $text)));
	  			?>
	  			<div class="text<?php echo ($textCount > 30) ? " large" : ""; ?>">
	  				<?php echo  $text; ?>
	  			</div>
	  			<div class="box-arquivar">
	  				<span>
	  				<?php if($s["ativo"]): ?> 
	  					<button
	  					type="button"
	  					class="toggle"
	  					data-type="ajax"
	  					data-alert="true"
	  					data-fn="notas;toggleNotas"
	  					data-post="id=<?php echo $s['id']; ?>&ativo=1"
	  					role="button"
	  					title="Arquivar anotação"
	  					aria-label="Arquivar essa anotação">
	  					 <i class="fa fa-close"></i>
	  					 <span class="legend">Arquivar</span>
	  					</button>
	  				<?php else : ?>
	  					<button
	  					type="button"
	  					class="toggle"
	  					data-type="ajax"
	  					data-alert="true"
	  					data-fn="notas;toggleNotas"
	  					data-post="id=<?php echo $s['id']; ?>&ativo=0"
	  					role="button"
	  					title="Reativar anotação"
	  					data-placement="left"
	  					data-toggle="tooltip"
	  					aria-label="Reativar anotação">
	  						<i class="fa fa-check"></i>
	  						<span class="legend">Reativar</span>
	  					</button>
	  				<?php endif; ?> 

	  				</span>
	  			</div>
	  		</div> <!-- content -->

	  		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" id="nota-detalhesid-<?php echo $s['id']; ?>" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content" >
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
			        <h4 class="modal-title">Nota: <strong><?php echo $s['assunto']; ?></strong> </h4>
			      </div>

			<div class="modal-body">
				<?php echo  $text; ?>
			 </div><!-- modal-body -->

			<div class="modal-footer">
			     <button class="cancel btn-default btn" data-dismiss="modal" aria-label="Fechar esta janela">Fechar</button>
			</div> <!-- modal-footer -->

			</form>
			</div>
			</div> <!-- modal -->

	  	</li>
	<?php
	  	}
	echo "</ul>";
	}else{
		 echo "<span class='alert-message'>Nenhuma nota cadastrada</span>";
	}
} // listar

function cadastrarNotas() {
	global $notas;
	global $erro;
	if(isset($_POST)) {
		
		$assunto = $_POST['assunto'];
		$texto = encodeEditor($_POST['texto']);

		if($notas->cadastrar($assunto,$texto)) {
			//$erro = "Nota '".$assunto."' cadastrada com sucesso";
		}
		echo $erro;
	}
}
function toggleNotas() {
	global $notas;
	global $erro;
	if($notas->toggle($_POST["id"])) {
		$ativo = ($_POST["ativo"]==1) ? "arquivada" : "reativada" ;
		$erro = "Nota {$ativo} com sucesso";
	}
	echo $erro;
}

if(isset($_GET["f"])) {
	$act = $_GET["f"];
	if(function_exists($act)) {
		$act();
	}
}

?>