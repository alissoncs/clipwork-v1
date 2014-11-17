<?php
	if(isset($_GET["f"])):
		include "../util.class.php";
	endif;
	
	Fluxo::db();
	Fluxo::classe("usuario");

	/*
		Limpa o conteúdo dentro do POST
	*/
	if(isset($_POST)):
		$_POST = Util::sanitize($_POST);
	endif;


	/*
		Instância de usuario
	*/
 	$usuario = new Usuario();

function logar($e=null,$s=null) {
	global $usuario;
	if(empty($e) && empty($s)):
		$usuario->login($_POST["email"],$_POST["senha"]);
	else:
		$usuario->login($e,$s);
	endif;
}
function cadastrar() {
	global $usuario;

	/*
		Cadastra novo usuário
	*/
	$aviso = $usuario->cadastrar($_POST);

	if(gettype($aviso) != "boolean"):
		Util::mensagem($aviso);
		Util::header("index");
	endif;
}

function editarDados() {
		global $usuario;
		global $erro;

		$usuario->setUsuarioId(Secao::get("idusuario"));

		$usuario->atualizarDados($_POST);

		echo $usuario->retorno;
}

function editarSenha() {
	global $usuario;

	$usuario->setUsuarioId(Secao::get("idusuario"));

	//print_r($_POST);
	 $usuario->atualizarSenha($_POST);

	 echo $usuario->retorno;
}

function execute() {
	echo "teste";
}
	Fluxo::executarF();

?>