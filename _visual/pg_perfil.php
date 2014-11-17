<?php
	
	Fluxo::classe("usuario");

	$usuario = new Usuario;

	$data = $usuario->getDadosUsuario();
?>


<div class="container-fluid padd all">

<header class="master row">
	<h1>Perfil de usuário</h1>
	<h3 class="hide">Nesta página você verá todos os trabalhos que tem cadastrado</h3>
	<div><small class="red-info">* Campos obrigatórios</small></div>
</header>

<div class="row">

	<div class="data-user col-xs-12 col-md-6">
		<form class="main-form no-clear" rel="ajax" data-fn="usuario;editarDados">
			<fieldset class="row">
				

				<legend class="sr-only">
					Informações básicas: Nome e sobrenome
				</legend>
				<label for="nome" class="col-xs-12 col-md-6">
					Nome: <i class="required"></i>
					<input type="text" class="nome" name="nome" title="Nome de usuario" value="<?php echo $data["nome"]; ?>" required>
				</label>
				<label for="sobrenome" class="col-xs-12 col-md-6">
					Sobrenome: <i class="required"></i>
					<input type="text" class="sobrenome" name="sobrenome" title="Sobrenome" value="<?php echo $data["sobrenome"]; ?>" required>
				</label>
			</fieldset>

			<div class="row">
				<hr>
			</div>

			<fieldset class="row">
				<legend class="sr-only">
					Atualizar dados (e-mail)
				</legend>
				<input type="hidden" name="idusuario" value="<?php echo $data["id"]; ?>" id="idusuario"/>
			
			<div class="row">
				<label for="email" class="col-xs-12 center-block">
					E-mail <i class="required"></i>
					<input type="email" name="email" value="<?php echo $data["email"]; ?>" title="O e-mail será utilizado no login" required>
				</label>
			</div>

			</fieldset>
	<hr>
			<fieldset>
				<legend>Opções: </legend>
				<div class="row">
					
					<div class="col-xs-12 col-md-6">
						<label for="notificacao">
							<input type="checkbox" title="Habilitar notificações por e-mail" name="email_notificacao"
								<?php if($data["email_notificacao"]) echo "checked";  ?>
							/> 
							Habilitar notificações por e-mail
						</label>

						<label for="auto_salvamento">
							<input type="checkbox" title="Habilitar auto salvamento na edição de tópicos"
							name="auto_salvamento"/>
							Edição com auto salvamento
						</label>

					</div>
					
					<div class="col-xs-12 col-md-6">
						<label for="modo_acessivel">
							<input type="checkbox" title="Habilitar modo acessibilidade" 
							name="modo_acessivel"/> 
							<i class="fa fa-wheelchair"></i> Modo acessível				
						</label>
						
					</div>

				</div>
			</fieldset>

			<fieldset class="form-submit col-xs-12 center-block">
				<br>
				<span class="" data-placement="right" data-toggle="tooltip" title="Salvar alterações">
					<button type="submit" class='btn green' title="Salvar informações de perfil">
					<i class="fa fa-check"></i>
					Salvar</button>
				</span>
			</fieldset>

		</form>
	</div>

	<div class="col-xs-12 col-md-5">
		<div class="experience-box" id="alterar-senha">
			<h2 class="title">Alterar senha</h2>
			<form rel="ajax" data-fn="usuario;editarSenha">
				<label for="senhaatual">
					Senha atual: <i class="required"></i>
					<input type="password" name="senhaatual" title="Digite a senha atual" required>
				</label>
				<label for="novasenha">
					Nova senha: <i class="required"></i>
					<input type="password" name="novasenha" title="Digite a nova senha" required>
				</label>
				<label for="novasenharep">
					Repita a nova senha:<i class="required"></i>
					<input type="password" name="novasenharep" title="Repita a nova senha" required>
				</label>
				<div class="form-submit text-right">
					<button type="submit" title="Salvar nova senha" class="btn">
						<i class="fa fa-check"></i>
						Salvar
					</button>
				</div>
			</form>
		</div>	
	</div> <!-- new-password -->

</div>

</div>