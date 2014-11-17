<?php
	if(isset($_GET["f"])):
		include "../util.class.php";
		Fluxo::db();
	endif;
	
	
	Fluxo::classe("projeto");

	Fluxo::classe("inclusoes");

	/*
		Limpa o conteúdo dentro do POST
	*/
	if(isset($_POST)):
		$_POST = Util::sanitize($_POST);
	endif;


	/*
		Inicia seção
	*/
		Secao::criar();

	/*
		Instancia e seta o nome de usuário
	*/
	global $projeto;
	$projeto = new Projeto();

 	$projeto->setIDUsuario(Secao::get("idusuario"));

 	$projeto->setID(Fluxo::idprojeto());



function listarProjetos() {

 global $projeto;

 $inclusoes = new Inclusoes();

 $query = $projeto->listar();

if($query) {
foreach ( $query as $l ) {
	$a = $inclusoes->incluidos($l['id']);
	$inc = $a !== false;
?>
	<article rel="bookmark" class="row li" id="project-<?php echo $l['id']; ?>">
	<a href="projeto.php?id=<?php echo $l['id']; ?>" class="row a" role="button" title="Editar trabalho: <?php echo $l['nome']; ?>">

		<hgroup class="<?php if($inc) { echo "col-xs-12 col-md-9"; } else { echo "col-xs-12"; }?>">
			<h3 aria-label='Título do trabalho'><?php echo $l['nome']; ?></h3>
		<?php if($l['assunto'] !== "") { ?><h6 class="assunto"><?php echo $l['assunto']; ?></h6> <?php } ?>
		</hgroup>
			<!-- <p class="descricao"><?php //echo $l['descricao']; ?></p> -->
<!-- Usuarios incluidos -->
		<?php
		if( $inc ) { ?>
		<div class="col-xs-12 col-md-3 friendship">
			<h6><i class="fa fa-group"></i>Junto com:</h6>
			<p class="incluidos">
				<?php foreach($a as $inc) { ?>
				<?php echo "<span>".$inc["nome"]."</span>"; ?>
				<?php } ?>
			</p>
		</div>
		<?php } ?>

		<button class="edit-project" type='button' title='Editar trabalho <?php echo $l['nome']; ?>'>
			<span class="fa fa-edit"></span>
			<span class="sr-only">Editar <?php echo $l['nome']; ?></span>
		</button>

	</a> <!-- row -->

	</article>
	<?php }}else { echo "<span class='alert-message'>Nenhum trabalho cadastrado.<br> Cadastre um novo trabalho</span>"; }
} // Listar

function cadastrarProjeto() {
	global $projeto;

 	/*
		Passa os atributos
 	*/

 	$projeto->setData($_POST);

 	/*
		Executa
 	*/

 	$status = ($projeto->cadastrar()) ? "Trabalho cadastrado com sucesso" : "Ocorreu um erro";
	// $status = $projeto->cadastrar();

 	/*
		Pega o ID e instancia as inclusões
 	*/

	$inclusoes = new Inclusoes($projeto->getRecente());
	$inclusoes->inserir($_POST['usuarios-incluidos']);

	Util::mensagem($status);
	Util::header("linha.php?pg=listar");

}

function incluirUsuario() {
	$email = $_POST["email"];
	
	Fluxo::classe("usuario");
	$inclusoes = new Inclusoes();
	$json = $inclusoes->verificar($email);

	if($json):
	?>
	<span class='usuario' id="span-incluido-<?php echo $json["id"]; ?>" data-email="<?php echo $json["email"]; ?>">
		<?php echo $json["nome"]." ".$json["sobrenome"]; ?>
		<button type="button" class='remove' aria-label="Remover <?php echo $json["nome"]; ?>"><i class="fa fa-remove"></i></button>
		<input type="hidden" value="<?php echo $json["id"]; ?>" name="usuarios-incluidos[]">
	</span>
	<?php
	else:
		echo "Usuário não encontrado";
	endif;

}
function excluirTrabalho() {
	global $projeto;

	Fluxo::classe("usuario");

	$status = $projeto->excluir($_POST);

	if( $status ):
		Util::mensagem("Projeto excluído com sucesso!");
		Util::header("linha.php?pg=listar");
	else:
		Util::mensagem($projeto->retorno);
		Util::header("projeto.php?id=".Fluxo::idprojeto()."&editar=config");
	endif;
}

function atualizarConfig() {

	global $projeto;

	/*
		Salva as configurações básicas
	*/
	$projeto->salvaConfig($_POST);

	/*
		Pega o ID e instancia as inclusões
 	*/

	$inclusoes = new Inclusoes($projeto->getRecente());
		
	/*
		Insere inclusões
	*/
	$inclusoes->inserir($_POST['usuarios-incluidos']);


	Util::mensagem($projeto->retorno);
	Util::header("projeto.php?id=".Fluxo::idprojeto()."&editar=config");

}

/*
	Atualizar dados da capa
*/
function atualizarDados() {
	global $projeto;

	if( $projeto->setDadosCompletos($_POST) ) $erro = "Informações salvas com sucesso!";

	Util::mensagem($erro);
	Util::header("projeto.php?id=".$_POST['idprojeto']."&editar=capa");
}

/*
	Inclusoes
*/

function listarNaoAceitos() {

	$inclusao = new Inclusoes;
	$inclusao->setUsuario(Secao::get("idusuario"));
	
	$aceitofalse = $inclusao->listar(0);

	if($aceitofalse !== false):
		
		echo "<article id='naoaceitos' class='novas-inclusoes'>";
		echo "<h4>Novos trabalhos para você acompanhar!</h4><ul>";
		foreach($aceitofalse as $linha):
		?>
			<li class="inclusao-nova-<?php echo $linha['id']; ?>">
				<p>
					<strong class="username"><?php echo $linha['usuarionome']; ?></strong>
					convidou você para participar do trabalho 
					<em class="projetonome"><?php echo $linha['projetonome']; ?></em>
				</p>
				<div class="btn-group btn-sm-group">

					<button type="button" class="btn blue btn-sm" data-alert="true"
					data-type="ajax" data-fn="projeto;recusarOuAceitarInclusao"
					data-post="id=<?php echo $linha['id']; ?>&aceitar=true">Aceitar</button>

					<button type="button" class="btn btn-default btn-sm" data-alert="true"
					data-type="ajax" data-fn="projeto;recusarOuAceitarInclusao"
					data-post="id=<?php echo $linha['id']; ?>&aceitar=false">Recusar</button>

				</div>
			</li>
		
	<?php
		endforeach;

		echo "</ul></article>";
	else:
		echo "<span class='alert-message'>Nenhum trabalho pendente para aprovação</span>";
	endif;

}
function listarAcompanhando() {

	$inclusao = new Inclusoes;
	$inclusao->setUsuario(Secao::get("idusuario"));
	
	$aceitotrue = $inclusao->listar(1);

	if($aceitotrue !== false):
		
		echo "<div id='acompanhando-aceitos' class='lista-acomp'>";
		echo "<h4>Acompanhando</h4>";
		foreach($aceitotrue as $linha):

		?>
	<article class="acompanhando-<?php echo $linha['id']; ?>">
		<div class='book row'>
			
			<div class="col-md-9 col-xs-7 info">
				<a class="row" title='Visualizar trabalho <?php echo $linha['projetonome']; ?>' 
					href="projeto.php?id=<?php echo $linha['idprojeto']; ?>">
					
					<h4 class="title"><?php echo $linha['projetonome']; ?></h4>
					<em class="text-by">De 
						<strong class="username"><?php echo $linha['usuarionome']; ?></strong>
					</em>
				</a>
			</div>
			
			<div class="col-md-3 col-xs-4 buttons">
				<p class="group text-right">
					<a href="#" class="btn btn-default" title="Acompanhar">
						<i class="fa fa-sign-in"></i>
						<span class="sr-only">Acompanhar</span>
					</a>
				</p>
			</div>
		
			</a>
		</article>
		
	<?php
		endforeach;

		echo "</div>";
	else:
		echo "<span class='alert-message'>Você não acompanha nenhum trabalho</span>";
	endif;

}


/*
	Função para aceitar ou não as inclusões
 */

function recusarOuAceitarInclusao() {
	
	$inclusao = new Inclusoes;
	$inclusao->setUsuario(Secao::get("idusuario"));
	$inclusao->aprovar($_POST);
	echo $inclusao->retorno;
}

/**
 * [listarIncluidosCompleto description]
 * Página de configuração
 * @return [null] [description]
 */
function listarIncluidosCompleto() {

	$inclusao = new Inclusoes;

	$listagem = $inclusao->incluidos(ID_PROJETO);
	
	foreach($listagem as $linha):
	?>
		<div class="user expand" id='id-incluido-<?php echo $linha['usuarioid']; ?>'>

			<h5 class="user-name" 
			data-toggle="modal" 
			data-target="#modal-user-config-<?php echo $linha['usuarioid']; ?>"><?php echo $linha['nome']; ?></h5>

			<?php if($linha['aceito'] == 0): ?>
				<span class="waiting status">
					Aguardando aprovação
				</span>
			<?php else: ?>	
				<span class="accept status">
					Aprovado
				</span>
			<?php endif; ?>

			<span class="configure">
				<a href='#expand' 
				class="toggle-user-config btn btn-small btn-default" 
				data-toggle="modal" 
				data-target="#modal-user-config-<?php echo $linha['usuarioid']; ?>">
					<i class='fa fa-cog'></i>
					<span class='sr-only'>Configurações de permissão</span>
				</a>
			</span>
		</div>
		<!-- Modal de configurações -->
			<div class="modal fade" id="modal-user-config-<?php echo $linha['usuarioid']; ?>" tabindex="-1" role="dialog" aria-labelledby="Configurações de permissão do usuário <?php echo $linha['nome']; ?>" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
			    	<form action="_acoes/projeto.php?f=salvarPermissoes" method="POST">

				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
				        <h4 class="modal-title">Configurações de permissão: <?php echo $linha['nome']; ?></h4>
				      </div>

				      <div class="modal-body">
						Permissões de <strong><?php echo $linha['nome']; ?></strong>:
							<hr>

						<div class="row">
								
							<label for="comentario">
								<input type="checkbox" name="comentario" title="Permitir comentários"
								<?php //if($linha['comentario'] > 0): echo "checked"; endif;  ?> checked disabled/>

								<span>Comentários</span>
							</label>

							<label for="topico">
								<input type="checkbox" name="topico" title="Permitir tópico"
								<?php if($linha['topico'] > 0): echo "checked"; endif;  ?> />
								<span>Tópicos</span>
							</label>

							<label for="referencia">
								<input type="checkbox" name="referencia" title="Permitir referências"
								<?php if($linha['referencia'] > 0): echo "checked"; endif;  ?> />
								<span>Referências</span>
							</label>
							
							<label for="anexo">
								<input type="checkbox" name="anexo" title="Permitir anexos"
								<?php if($linha['anexo'] > 0): echo "checked"; endif;  ?> />
								<span>Anexos</span>
							</label>

							<label for="notas">
								<input type="checkbox" name="notas" title="Permitir visualização das anotações"
								<?php if($linha['notas'] > 0): echo "checked"; endif;  ?> />
								<span>Anotações</span>
							</label>

							<label for="pdf">
								<input type="checkbox" name="pdf" title="Permitir visualização do arquivo PDF"
								<?php if($linha['pdf'] > 0): echo "checked"; endif;  ?> />
								<span>Permitir visualização do arquivo PDF</span>
							</label>
						<input type="hidden" name="idusuario" value="<?php echo $linha['usuarioid']; ?>"/>
						<input type="hidden" name="id" value="<?php echo $linha['id']; ?>"/>
						<input type="hidden" name="idprojeto" value="<?php echo ID_PROJETO; ?>"/>
						</div>

					  </div>

					  <div class="modal-footer">
						<button type="submit" name="remover" class="btn pull-left" title="Remover usuário do trabalho">
							<i class="fa fa-trash"></i>
							Remover usuário
						</button>

					  	 <button class="cancel btn-default btn" data-dismiss="modal">Cancelar</button>
					  	 <button type="submit" class="btn green" name="salvar"><i class="fa fa-check"></i>Salvar</button>
					  </div>

					</form>
				</div>
				</div>
			</div> <!-- modal -->
	<?php
	endforeach;
}

function salvarPermissoes() {

	$inclusao = new Inclusoes(Fluxo::idprojeto());

	if(isset($_POST['remover'])):
		removerIncluido();
		return false;
	endif;

	$inclusao->salvarPermissoes($_POST);

	Util::mensagem($inclusao->retorno);
	Util::header("projeto.php?id=".Fluxo::idprojeto()."&editar=config");

}

function removerIncluido() {

	$inclusao = new Inclusoes(Fluxo::idprojeto());
	
	$inclusao->excluir($_POST);

	Util::mensagem($inclusao->retorno);
	Util::header("projeto.php?id=".Fluxo::idprojeto()."&editar=config");

}

// FC
if(isset($_GET["f"])) {
	$act = $_GET["f"];
	if(function_exists($act)) {
		$act();
	}
}
?>
