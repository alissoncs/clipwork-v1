<div class="padd all">
<header class="row">

	 <div class="col-xs-12 col-lg-6">
		<div class="master row m-0">
			<h1>Detalhes do projeto</h1>
			<h5 class="name"><?php echo $info["nome"]; ?></h5>
		</div>
	 </div>

	 <div class="col-xs-12 col-md-6 hide">
	 	<h4><small>Informações</small></h4>

	 <div class="pj-counter">	
	 <ul> 	
	 	<li class="anexos">Anexos 
	 		<strong class="counter"><?php echo $info["anexo"] ?></strong>
	 	</li>
	 	<li class="comentarios">Comentários 
	 		<strong class="counter"><?php echo $info["numcoment"] ?></strong>
	 	</li>
	 	<li class="topicos">Tópicos
	 		<strong class="counter"><?php echo $info["topico"] ?></strong>
	 	</li>
	 	<li class="referencias">Referências 
	 		<strong class="counter"><?php echo $info["referencia"] ?></strong>
	 	</li>
	 	<li class="notas">Notas
	 		<strong class="counter"><?php echo $info["nota"] ?></strong>
	 	</li>
	 </ul>
	 </div> <!-- pj-counter -->

	 </div>
</header>
<hr>

<div class="row">

<!-- detalhes de edicao -->
<div class="bsp-edit row">

<form class="main-form col-xs-12 col-md-6" action="_acoes/projeto.php?f=atualizarConfig" method="post">
<fieldset>
	<legend class="sr-only">Informações básicas</legend>
		<label for="nome">
			Nome: <i class="required"></i>
			<input type="text" name="nome" value="<?php echo $info["nome"]; ?>" required>
		</label>

		<label for="assunto">
			Assunto:
			<input type="text" name="assunto" value="<?php echo $info["assunto"]; ?>">
		</label>

		<label for="descricao">
			Descrição:
			<textarea class="description" name="descricao"><?php echo $info["descricao"]; ?></textarea>
		</label>

		<label for="data">
			Data de entrega:
			<input type="date" class="data" name="data" value="<?php echo $info["data"]; ?>" placeholder="00/00/0000">
		</label>
</fieldset>
<fieldset>
	
	<div class="visible-sm visible-xs"><hr></div>

	<legend class="sr-only">Incluir pessoas</legend>
	<div class="incluir-pessoas set-people" id="set-people">
        <label for="incluir">Incluir pessoas
          
          <div class="input-group">
          	<input type="text" name="incluir" id="input-new-user" title="Insira o e-mail da pessoa que deseja"/>
          	
          	<a href="#" role="button" class="submit" data-toggle="tooltip" data-placement="top" title="Adicionar colaborador">
          		<i class="fa fa-plus"></i>
          		<span class="sr-only">Adicionar usuário</span>
          	</a>
      	  </div>

      	  <h6 class="sr-only">Pessoas incluídas:</h6>
      	  <ul class="pessoas-incluidas sed-people" id="seted-people">
		  </ul>
		</label>

     	  
	</div> <!-- set-people -->

	<div class="habilitar">
		<label for="autosalvar">
			<input type="checkbox" name="autosalvar" 
			<?php if($info["autosalvar"] == 1) echo "checked"; ?>
			/> Habilitar auto-salvamento
		</label>
	<hr>
	</div>

	<div class="row foot-form">
		<input type="hidden" value="<?php echo ID_PROJETO; ?>" name="idprojeto"/>
		<button type="submit" class="btn green" aria-label="Salvar alterações">Salvar</button>

		<button class="btn" role="button" type="button" data-toggle="modal" data-target="#excluir-trabalho">
			<i class="fa fa-trash" aria-hidden="true"></i>
			Excluir trabalho
		</button>
	</div>

</fieldset>
</form> <!-- form -->

	<div class="col-xs-12 col-md-6">
		<?php
		 	include(CONTROL."projeto.php");
		?>
		<?php if($info['inc'] > 0): ?>
		<div class="included-people experience-box">
			<h3 class="legend"><i class="fa fa-group"></i>
				Pessoas que acompanham o trabalho</h6>
				<div class="content row">
					<?php listarIncluidosCompleto(); ?>
				</div>
			</p>
		</div>
		<?php endif;?>
	</div>


</div>
<!-- detalhes de edicao -->

</div> <!-- row -->
</div>

<div class="modal fade" id="excluir-trabalho" tabindex="-1" role="dialog" aria-labelledby="Excluir trabalho <?php echo $info["nome"]; ?>" aria-hidden="true">
  <div class="modal-dialog modal-md">

    <form class="modal-content" 
    method="post" action="_acoes/projeto.php?f=excluirTrabalho" 
    data-fn="projeto;excluirTrabalho">
	     
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar janela</span></button>
	        <h4 class="modal-title">Excluir trabalho <strong class="p_title"><?php echo $info["nome"]; ?></strong></h4>
	      </div>

	<div class="modal-body">
	      	
		<p>
			Tem certeza que deseja excluir este trabalho?
		</p>	
		<p class="alert-message">
			Todos os itens que fazem parte do trabalho, como comentários, anexos, tópicos e referências serão excluidos.
		</p>
	<hr><br>
		<div class="get-password" role="presentation">
			<label for="senha" aria-label="Campo obrigatório">
				<span>Digite sua senha (usuário) 
					<i class="required"></i>
				</span>
				<div class="row pass-area">
					<div class="col-xs-12 col-sm-6 clear-padd">
						<input type="password" name="senhausuario" title="Digite sua senha (usuário)" value="" required/>
					</div>
				</div>
			</label>
		</div>

		<div class="hide">
			<input type="hidden" name="idprojeto" value="<?php echo $info["id"]; ?>" class="hide">
		</div>

	</div> <!-- modal-body -->

		  <div class="modal-footer">
		  		<span class="spinner small" arial-label="Carregando"></span>
		  		<button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
		  		<button type="submit" class="btn" aria-label="Excluir projeto"><i class="fa fa-check"></i>Excluir</button>
		  </div>

	</form>
</div>
</div>
