<?php
class Usuario {

	private $tabela = "usuario";
	public $retorno = "Ocorreu um erro, tente novamente";
	private $mysql;
	private $idusuario;

		private $c_nome = "nome";
		private $c_email = "email";
		private $c_sobrenome = "sobrenome";
		private $c_senha = "senha";

		private $email;
		private $senha;

	public function __construct() {
		$this->mysql = new mysql;
	}

	/**
	 * [setUsuarioId description]
	 * @param [int] $idusuario [id do usuario]
	 */
	public function setUsuarioId($idusuario) {
		$this->idusuario = $idusuario;
	}

	public function login($email,$senha) {
		
		// Criptografa a senha de usuario
		$senha = Util::cript($senha);

		$q = "SELECT id,nome,sobrenome,email FROM $this->tabela WHERE email = '$email' AND senha = '$senha'";
		$query = $this->mysql->listar($q);
		
		/*
			Se encontrar usuário:
			Inicia as variáveis de secao
		*/

		if(isset($query)):
			Secao::criar();

			Secao::variavel("nome",$query["nome"]);
			Secao::variavel("sobrenome",$query["sobrenome"]);
			Secao::variavel("nome_sobrenome",$query["nome"]." ".$query["sobrenome"]);
			Secao::variavel("idusuario",$query["id"]);
			Secao::variavel("email",$query["email"]);
			
			Util::header("linha");

		endif;

	}

	public function emailExiste($email,$senha = null) {
		$q = "SELECT * FROM ".$this->tabela." WHERE $this->c_email='$email'";
		if( $this->mysql -> existe( $q ) ) {
			return true;
		}
	}

	public function verificaEmail($email) {
		return $this->mysql->existe("SELECT id FROM $this->tabela WHERE email = '$email'");
	}

	/*
		Pega informações básicas
	*/
	public function info($email) {

		return $this->mysql->listar("SELECT id,nome,sobrenome,email FROM $this->tabela WHERE email='$email'");

	}

	public function cadastrar($post) {
		if(empty($post["senhacad"])) return "A senha não pode ser vazia";
		if(empty($post["email"])) return "Campo de e-mail é obrigatório";
		if(empty($post["nome"])) return "Campo de nome é obrigatório";

		if($this->verificaEmail($post["email"])) return "Já existe uma conta com esse e-mail";

		$senha = Util::cript($post["senhacad"]);

		// Finalmente inserindo
		$q = "INSERT INTO $this->tabela (nome,sobrenome,email,senha) VALUES ";
		$q .= "('".$post["nome"]."','".$post["sobrenome"]."','".$post["email"]."','".$senha."')";
		
		/*
			Agora executa o login
		*/
			$this->mysql->inserir($q);
			$this->login($post["email"],$post["senhacad"]);

		return true;

	}

	public function testaSenha($id=null,$senha) {

		if($id == null) $id = $this->idusuario;

		$q = "SELECT * FROM $this->tabela WHERE senha='$senha' AND id=$id";
		
		return $this->mysql->existe($q);
	}

	public static function news($tipo) {
		$db = new mysql;
		
		$q = "SELECT count(*) as acompanhe FROM inclusao WHERE idusuario = ".Secao::get("idusuario")." AND aceito = 0";

		$v = $db->listar($q);

		return $v[$tipo];
	}

	public function getDadosUsuario($idusuario = null) {
		if($idusuario == null) $idusuario = Secao::get('idusuario');

		$query = "SELECT id,nome,sobrenome,email,email_notificacao,ativo FROM $this->tabela WHERE id = $idusuario";

		return $this->mysql->listar($query);
	}

	public function atualizarDados($data) {

		$array = array(
			"nome" => $data['nome'],
			"sobrenome" => $data['sobrenome'],
			"email" => $data['email'],
			"email_notificacao" => isset($data['email_notificacao']) ? 1 : 0
		);

			Secao::variavel("nome",$array["nome"]);
			Secao::variavel("sobrenome",$array["sobrenome"]);
			Secao::variavel("nome_sobrenome",$array["nome"]." ".$array["sobrenome"]);
			Secao::variavel("email",$array["email"]);

		$update = $this->mysql->arrayTo($array,"update");

		$q = "UPDATE $this->tabela SET {$update} WHERE id = $this->idusuario";
		// $this->retorno = $q;
		if($this->mysql->atualizar($q)) $this->retorno = "Dados alterados com sucesso";
		return true;
		 //$this->retorno = $q;

	} 

	/**
	 * Atualiza a senha de usuário
	 */
	public function atualizarSenha($data) {

		// Criptografa as senhas
		foreach($data as $key => $value):
			$data[$key] = Util::cript($value);
		endforeach;

		if( !$this->testaSenha(null,$data['senhaatual']) ):
		 $this->retorno = "Senha atual incorreta"; return false;
		endif;


		if($data['novasenha'] != $data['novasenharep']):
			$this->retorno = "Senhas diferentes"; return false;
		endif;

		$q = "UPDATE $this->tabela SET senha = '{$data['novasenharep']}' WHERE id = $this->idusuario";

		// $this->retorno = $q;

		if($this->mysql->atualizar($q)) :
			$this->retorno = "Senha atualizada com sucesso!"; 
			return true;
		endif;

		return false;
	}

	public static function sair() {
		
		/*
			Limpa as variáveis de seção
		*/
		Secao::excluir();

		/*
			Redireciona para tela de login
		*/
		Util::header("index.php");
	}
}

?> 