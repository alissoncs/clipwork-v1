<?php
class Projeto {

	private $tabela = "projeto";
	private $tbinclusao = "inclusao";

	protected $mysql;
	protected $idusuario;
	protected $idprojeto;

	private $erro;
	private $data;

	private $permissao;
	private $tipoacesso;
	public $retorno = "Ocorreu um erro. Tente novamente!";

	//campos
	private $c_idusuario = "idusuario";
	private $c_nome = "nome";
	private $c_assunto = "assunto";
	private $c_descricao = "descricao";
	private $c_idtipo = "idtipo";
	private $c_data = "data";
	private $c_atualizacao = "atualizacao";

	public function __construct($u=null,$p=null) {

		/*
			Instância da classe mysql
		*/

		 $this->mysql = new mysql;

		 /*
			Setters pelo construtor
		 */
		 if($u!=null):
		 	$this->idusuario = $u;
		 endif;

		 if($p!=null) :
		 	$this->idprojeto = $p;
		 endif;
	}


	/*
		Seta o id do projeto
	*/
	public function setID($id) {
		return $this->idprojeto = $id;
	}
	protected function getID() {
		return $this->idprojeto;
	}

	/*
		Seta o id do usuário
	*/
	public function setIDUsuario($id) {
		return $this->idusuario = $id;
	}
	public function getIDUsuario() {
		return $this->idusuario;
	}
	/*
		Seta data (POST ou Array)
	*/
	public function setData($data) {
		$this->data = $data;
	}

	/*
		Retorna a query de projetos pelo ID do usuário
	*/
	public function listar() {
		$query = $this->mysql->query("SELECT * FROM $this->tabela WHERE idusuario = $this->idusuario ORDER BY id DESC"); 
		return $query;
	}

	/*  
		Cadastra um projeto
	 */

	public function cadastrar(){
		$data = $this->data;

		$values = array(
			"idusuario"=>$this->idusuario,
			"nome"=>$data["nome"],
			"assunto"=>$data["assunto"],
			"descricao"=>nl2br($data["descricao"]),
			"data"=>$data["data"],
			"atualizacao"=>"CURRENT_TIMESTAMP()"
			);

		$insert = $this->mysql->arrayTo($values,"insert");

		$q = "INSERT INTO $this->tabela {$insert}";

		//return $q;
		return $this->mysql->inserir($q);
	}

	/*
		Pega o ID do último projeto cadastrado
	*/
	public function getRecente() {
		$q = "SELECT id FROM $this->tabela WHERE idusuario = $this->idusuario ORDER BY id DESC LIMIT 1";
		$id = $this->mysql->listar($q);
		return $id["id"];
	}

	public function getInfo($info=null) {

	   $doc = array(
		"comentarios" => "(select count(*) from comentario WHERE idprojeto = $this->tabela.id) as numcoment,",
		"inclusoes" => "(select count(*) from inclusao WHERE idprojeto = $this->tabela.id) as inc,",
		"anexo" => "(select count(*) from anexo WHERE idprojeto = $this->tabela.id) as anexo,",
		"topico" => "(select count(*) from topico where idprojeto = $this->tabela.id) as topico,",
		"referencia" => "(select count(*) from referencia where idprojeto = $this->tabela.id) as referencia,",
		"notas" => "(select count(*) from notas where idprojeto = $this->tabela.id) as nota,",
		"usuarionome" => "(SELECT usuario.nome from usuario WHERE id = $this->tabela.idusuario) as usuarionome,",
		"integrantes" => "(SELECT GROUP_CONCAT(usuario.nome, ' ', usuario.sobrenome SEPARATOR ',') FROM usuario,inclusao WHERE inclusao.idprojeto = projeto.id AND usuario.id = inclusao.idusuario) as integrantes"
	   );

		$exc = implode($doc);

		$q = "SELECT $this->tabela.*, $exc FROM $this->tabela WHERE id = $this->idprojeto";
		return $this->mysql->listar($q);
	}
	

	/*
		Verifica se usuário pode acessar o projeto
		@param idprojeto e idusuario
	*/
	public function autenticar($idusuario=null,$idprojeto=null) {

		if($idusuario == null && $idprojeto == null):
			$idusuario = $this->idusuario;
			$idprojeto = $this->idprojeto;	
		endif;
		
		/*
			Verifica se usuário tem total permissão ao projeto
		*/
		$q = "SELECT id FROM $this->tabela WHERE id = $idprojeto AND idusuario = $idusuario";
		$q1 = "SELECT * FROM $this->tbinclusao WHERE idprojeto = $idprojeto AND idusuario = $idusuario AND aceito = 1";
		$q2 = "SELECT * FROM $this->tbinclusao WHERE idprojeto = $idprojeto AND idusuario = $idusuario AND aceito = 0";

		if($this->mysql->existe($q)):
		
			$this->setPermissao("all");

		elseif ( $this->mysql->existe($q1) ):

			$this->setPermissao($q1);

		elseif( $this->mysql->existe($q2) ):

			Util::mensagem("Você não aprovou esse projeto.");
			Util::header("linha.php?pg=acompanhando");

		else:

			Util::mensagem("Trabalho não encontrado.");
			Util::header("linha.php?pg=listar");

		endif;
		
		return true;
	}


	/*
		private Seta as variaveis de permissão para acessar o projeto
		$this->permissao;
	*/
	private function setPermissao($select) {

		if($select === "all"):

			// Seta permissão total
			$this->permissao = array(
				"all"        => true,
				"pdf"        => 1,
				"comentarios"=> 1,
				"notas"      => 1,
				"topicos"    => 1,
				"referencias"=> 1,
				"anexo"      => 1
			);

		else:

			// Seta permissão conforme dados do banco
			if(is_string($select)):
				$select = $this->mysql->listar($select);
			endif;

				$this->permissao = array(
					"all"         => false,
					//"comentarios" => $select["comentario"],
					"comentarios" => 1,
					"referencias" => $select["referencia"],
					"anexo"       => $select["anexo"],
					"pdf"         => $select["pdf"],
					"notas"       => $select["notas"],
					"topicos"     => $select["topico"]
				);
		endif;

	}

	/*
		Get permissao // retorna o array de permissões de acesso
	*/
	public function getPermissao() {
		return $this->permissao;
	}

	/*
			Salva as configurações básicas
	*/
	public function salvaConfig($p) {

		$array = array(
			"nome"=>$p['nome'],
			"assunto"=>$p['assunto'],
			"descricao"=>nl2br($p['descricao']),
			"data"=>$p['data'],
			"autosalvar"=>isset($p['autosalvar']) ? 1 : 0
			);
		
		$array = $this->mysql->arrayTo($array,"update");

		$q = "UPDATE $this->tabela SET {$array} WHERE id = $this->idprojeto AND idusuario = $this->idusuario";

		$this->retorno = ($this->mysql->atualizar($q)) ? "Salvo com sucesso!" : "Ocorreu um erro";
	}


	/*
			Dados completos (capa)
	*/

	public function setDadosCompletos($p=null) {

		$data = array(
			"titulocompleto"=> $p['titulocompleto'],
			"subtitulo"=> $p['subtitulo'],
			"entidade"=>$p['entidade'],
			"curso"=> $p['curso'],
			"autores"=>$p['autores'],
			"orientador"=>$p['orientador'],
			"coorientador"=>$p['coorientador'],
			"cidade"=>$p['cidade'],
			"data"=>$p['data'],
			"natureza"=>$p['natureza'],
			"resumo"=>$p['resumo']
			);
		
		$update = $this->mysql->arrayTo($data,"update");
		
		$q = "UPDATE $this->tabela SET {$update} WHERE id = ".$p['idprojeto'];

		return $this->mysql->atualizar($q);
	}


	/*
		Método para excluir um projeto
	*/
	public function excluir($data) {

		$usuario = new Usuario;

		$senha = Util::cript($data['senhausuario']);

		/*
			Verifica a senha do usuario
		*/
		$testaSenha = $usuario->testaSenha($this->idusuario,$senha);

		if($testaSenha == false):
			$this->retorno = "Senha de usuário incorreta!";
			return false;
		else:
		 	// Deleta no banco
			$q = "DELETE FROM $this->tabela WHERE id={$this->idprojeto} AND idusuario = {$this->idusuario}";

			$this->mysql->excluir($q);

			$this->retorno = "Trabalho excluído com sucesso!";

			return true;
			
		endif;
	}

	/**
	 * Get default - retorna a página que será a default com base nas permissões
	 */
	public function getDefault($pg) {
		if($pg == null):
			if($this->permissao['all'] == true):
				return "topicos";
			endif;

			if($this->permissao['all'] == false):
				// verifica permissao
				foreach($this->permissao as $index => $p):
					if($p == 1 && $index != "all"):
						return $index;
						break;
					endif;
				endforeach;
			endif;
		endif;

		return $pg;
	}

}



?>