<?php	
	include "_acoes/anexo.php";
?>
<div class="container-fluid clear-padd">

<?php if( isset($_REQUEST["cadastrar"]) || isset($_GET["idanexo"])   ) : ?>
<?php $link = (isset($_GET["idanexo"])) ? true : false; ?>

<?php
if($link) :
	$idanexo = $anexo->setIdAnexo($_GET["idanexo"]);
	if(!$anexo->verifica()) : setMensagem("Anexo não encontrado"); header("Location: projeto.php?id=".Fluxo::idprojeto()."&editar=anexo"); endif;
	$c = $anexo->getConteudo();
endif;
?>

<?php $formaction = (!$link) ? "_acoes/anexo.php?f=cadastrarAnexo" : "_acoes/anexo.php?f=atualizarAnexo";?>

<form id="cadastrar-anexo" name="cadastrar-anexo" action="<?php echo $formaction; ?>" method="post" class="row cadastrar-anexo">

	<div class="col-lg-4 col-xs-12">
		<header class="master row">
			<?php if($link) : ?>
				<h1><small>Editar <?php echo $c["tipo"]?></small></h1>
			<?php else: ?>
				<h1><small>Anexos / Apêndices</small></h1>
			<?php endif; ?>
		</header>

		<?php $titulo = ($link) ? "'".$c["titulo"]."'" : "Inserir novo item";?>		
	<div class="row">
		<h2><?php echo $titulo; ?></h2>

		<p>Insira um anexo ou apêndice. Lembre-se de citá-lo dentro de seu trabalho com <strong>número do anexo</strong>.</p>
		<p>A numeração será inserida automaticamente.</p>

		<hr>
		<p><strong>Apêndice: </strong>
			documento ou texto elaborado pelo autor
		</p>
		<p><strong>Anexo:</strong>
			documento ou texto <em>não</em> elaborado pelo autor
		</p>
		<hr>
	</div> <!-- row -->
	<div class="row">
		<a href="projeto.php?id=<?php echo ID_PROJETO; ?>&editar=anexo" title="Voltar para a listagem" class="btn btn-default">
		<i class="fa fa-caret-left"></i> Voltar</a>
	</div>

	</div>

	<div class="col-lg-8 col-xs-12 padd this-separate">
	
	<div class="row">
		<label for="titulo" class="col-xs-12 col-md-6">
			<span>Título</span>
			<?php if($link) : ?>
				<input type="text" name="titulo" autocomplete="off" class="titulo-campo" value="<?php echo $c["titulo"]; ?>" required>
			<?php else: ?>
				<input type="text" name="titulo" autocomplete="off" class="titulo-campo" placeholder="Título do anexo" required>
			<?php endif; ?>
		</label>
		<label for="titulo" class="col-xs-12 col-md-6">
			<span>Tipo</span>
			<select name="tipo">
				<?php if($link) : ?>
					<option value="apendice" <?php if($c["tipo"] == "apendice") : echo "selected"; endif; ?>>Apêndice</option>
					<option value="anexo" <?php if($c["tipo"] == "anexo") : echo "selected"; endif; ?>>Anexo</option>
				<?php else: ?>
					<option value="apendice">Apêndice</option>
					<option value="anexo">Anexo</option>
				<?php endif; ?>
			</select>
		</label>
	</div>

	<?php if($link) : ?>
		<input type="hidden" value="<?php echo $c["id"]; ?>" name="id" class="hide">
		<input type="hidden" value="<?php echo $c["tipo"]; ?>" name="oldtipo" class="hide">
		<input type="hidden" value="<?php echo $c["ordem"]; ?>" name="ordem" class="hide">
		<input type="hidden" value="<?php echo ($c["tipo"] == "apendice") ? $c["ordem"] : $anexo->getContagem("apendice"); ?>" class="hide" name="apendice-ordem">
		<input type="hidden" value="<?php echo ($c["tipo"] == "anexo") ? $c["ordem"] : $anexo->getContagem("anexo"); ?>" class="hide" name="anexo-ordem">
	<?php else : ?>
		<input type="hidden" value="<?php echo $anexo->getContagem("apendice"); ?>" class="hide" name="apendice-ordem">
		<input type="hidden" value="<?php echo $anexo->getContagem("anexo"); ?>" class="hide" name="anexo-ordem">
	<?php endif; ?>
		<input type="hidden" value="<?php echo ID_PROJETO; ?>" name="idprojeto" class="hide">		


		<div class="editor">
			<textarea id="anexo-textarea" name="html">
				<?php if($link) : echo $c["html"];	endif; ?>
			</textarea>
		</div>
		
	<div class="submit-area row">
		<?php if($link) : ?>
		<div class="col-md-6 col-xs-12">
			<button type="button" class="delete btn big" data-toggle="modal" data-target="#excluir-item" value="Excluir">Excluir</button>	
		</div>
		<div class="col-md-6 col-xs-12">
		<?php endif; ?>
			<input type="submit" class="salvar btn big green" value="Salvar">	
		<?php if($link) : ?>
			</div>
		<?php endif; ?>
	</div>
	</div>

</form>
<?php if($link) : ?>
<!-- modal -->
<div class="modal fade" id="excluir-item" tabindex="-1" role="dialog" aria-labelledby="Excluir <?php echo $c["tipo"]?>" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="_acoes/anexo.php?f=excluirAnexo">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title">Excluir <?php echo $c["tipo"]?></h4>
	      </div>

	      <div class="modal-body">
	      	<p>Tem certeza que deseja excluir "<strong class="upper"><?php echo $c["tipo"]?></strong> - <?php echo $c["titulo"]?>"?</p>
			<input type="hidden" class="hide" value="<?php echo $c["id"]?>" name="id">
			<input type="hidden" class="hide" value="<?php echo $c["ordem"]?>" name="ordem">
			<input type="hidden" class="hide" value="<?php echo $c["tipo"]?>" name="tipo">
			<input type="hidden" value="<?php echo ID_PROJETO; ?>" name="idprojeto" class="hide">
			
			<input type="hidden" class="hide" value="<strong class='upper'><?php echo $c["tipo"]?></strong> - <?php echo $c["titulo"]?>" name="titulo">
		  </div>

		  <div class="modal-footer">
		  		<button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
		  		<input type="submit" class="btn" value="Excluir"/>
		  </div>

	</form>
</div>
</div>
<!-- modal -->
<?php endif; ?>

<?php else: ?>

<div class="anexos listagem col-md-10 col-xs-12">

	<div class="content padd all ">
		<header class="master row">
			<h1>Anexos</h1>
		</header>
		<div>
		<a href="projeto.php?id=<?php echo ID_PROJETO; ?>&editar=anexo&cadastrar" role="button" aria-label="Cadastrar anexo/apêndice" class="btn btn-default">
			<i class="fa fa-file"></i>Inserir
		</a>
		</div>

		<?php
		// Listar Anexos	
		// $anexo->setProjetoID(ID_PROJETO);
		$listagem = $anexo->listar();
		$check = false;
		if($listagem !== false) :
			foreach ($listagem as $linha) :
				if ($linha["tipo"] == "apendice" && $check == false ) : echo "<hr>"; $check=true; endif;
		?>
			<article role="article" class="anexo-apendice <?php echo $linha["tipo"]; ?> a-<?php echo $linha["id"]; ?>" data-id="<?php echo $linha["id"]; ?>" data-ordem="<?php echo $linha["ordem"]; ?>">
			<a href="projeto.php?id=<?php echo ID_PROJETO; ?>&editar=anexo&idanexo=<?php echo $linha["id"]; ?>">
				<div class="order pull-left">
					<big><span><?php echo $linha["ordem"]; ?></span></big>
				</div>
				<h5>
					<strong><?php 
					if(strtolower($linha["tipo"]) == "apendice"):
						echo "Apêndice";
					else:
						echo $linha["tipo"]; 
					endif;
					
					?></strong> -
					<span class="titulo"><?php echo $linha["titulo"]; ?></span>
				</h5>
			</a>
			</article>
		<?php
			endforeach;
		else:
			echo "<span class='alert-message'>Nenhum anexo cadastrado</span>";
		endif;
		?>
	</div>
</div>

<?php endif; ?>



</div>


