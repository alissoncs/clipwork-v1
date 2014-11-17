<div class="container-fluid padd all">

<header class="master row">
	<h1>Novo trabalho</h1>
	<h3 class="hide">Nesta página você pode criar novos trabalhos</h3>
</header>

<form id="cadastrar-projeto" class="col-xs-12 clear-padd col-lg-10" method="post" action="_acoes/projeto.php?f=cadastrarProjeto">

<fieldset class="col-xs-12 col-md-7">
	<legend class="hide">Informações básicas</legend>
	<label for="nome">
		Nome:
		<input type="text" required class="nome" name="nome" autocomplete="off" title="Preencha o nome do seu projeto" placeholder="Exemplo: Trabalho de Química"/>
	</label>
	<label for="assunto">
		Assunto:
		<input type="text" class="assunto" name="assunto" autocomplete="off" placeholder="Exemplo: Ácidos e suas peculiaridades" title="Do que se trata o seu projeto (opcional)"/>
	</label>
	<label for="descricao">
		Descrição:
		<textarea name="descricao" autocomplete="off" title="Digite uma descrição para seu trabalho"></textarea>
	</label>
</fieldset>


<fieldset class="col-xs-12 col-md-5">
	<legend class="hide">Detalhes</legend>
	<label for="data">
	Data de entrega:
		<input type="date" class="data datepicker" name="data" 
		title='Digite a data de entrega do trabalho' placeholder="00/00/0000"/>
	</label>

	<!-- <label for="idtipo" class="hide">
	Tipo de trabalho:
		<select name="idtipo">
			<option value="1">ABNT</option>
			<option value="2">APA</option>
		</select>
	</label> -->

	<div class="incluir-pessoas set-people" id="set-people">

          <label for="incluir">
          	Incluir pessoas

          	<p><small>Digite o e-mail do usuário que você deseja incluir</small></p>
          	
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
</fieldset>

<div class="submit-area row">
	
		<div class="col-md-5 col-sm-7 col-xs-12 pull-right">
			<button class="btn green big" type="submit" role='button' title='Cadastrar trabalho'>
				<i class="fa fa-check"></i>
				<span>Criar trabalho</span>
			</button>
		</div>

		<div class="col-md-7 col-sm-5 col-xs-12 pull-left">
			<br><a href="#" class="form-reset btn btn-default btn-sm" role="button" aria-label="Resetar formulário">
				<i class="fa fa-refresh"></i>
				Limpar formulário
			</a>
		</div>
</div> <!-- submit-area -->

</form>
</div>
