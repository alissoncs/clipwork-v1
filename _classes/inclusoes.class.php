<?php
class Inclusoes {

	private $tabela = "inclusao";
	private $idusuario;
	private $projeto;
	protected $mysql;
	public $retorno = "Ocorreu um erro desconhecido";

	public function __construct($p=false) {
		if(isset($p) || $p) {
			$this->projeto = $p;
		} 

		$this->idusuario = Secao::get("idusuario");

		$this->mysql = new mysql;
	}

	public function setUsuario($idusuario) {
		$this->idusuario = $idusuario;
	}
	public function getUsuario() {
		return $this->idusuario;
	}


	/**
	 * Insere no banco as incluões com o loop
	 * @param  [array] $usuario [name no form]
	 * @return [bool]          [status]
	 */
	public function inserir($usuario) {
		if(isset($usuario)):
			
			foreach($usuario as $val) :
				$verifica = "SELECT id from $this->tabela WHERE idprojeto = $this->projeto AND idusuario = $val";
				
				if($val != $this->idusuario && !$this->mysql->existe($verifica)):
						
					$q = "INSERT INTO $this->tabela (idusuario,idprojeto)";
					$q.= " VALUES ($val,$this->projeto)";
					$var = $this->mysql->inserir($q);
				endif;
			endforeach;

			return $var;
		endif;
	}

	public function verificar($email) {
		$usuario = new Usuario;
		return $usuario->info($email);
	}
	public function incluidos($idprojeto) {

		$q = "
			SELECT
			 CONCAT(usuario.nome, ' ', usuario.sobrenome) as nome,
			 usuario.id as usuarioid,
			 $this->tabela.*
			FROM $this->tabela, usuario
			WHERE idprojeto = $idprojeto
			AND $this->tabela.idusuario = usuario.id
		";
		return $this->mysql->query($q);
	}

	/*
		Lista todos os trabalhos ainda não aceitos pelo usuario
	*/

	public function listarNaoAceitos() {
		$q = "
			SELECT projeto.nome as projetonome,
				   CONCAT(usuario.nome, ' ', usuario.sobrenome) as usuarionome,
				   inclusao.id as id

			 FROM projeto, inclusao, usuario
			 WHERE projeto.id = inclusao.idprojeto
			 AND projeto.idusuario = usuario.id
			 AND inclusao.idusuario = $this->idusuario
			 AND inclusao.aceito = 0
		";

		return $this->mysql->query($q);
	}


	/**
	 * listar lista os trabalhos em que o usuário acompanh
	 * @param  [int] $aceito [status de acompanhmento]
	 * @return [array]         [query do banco]
	 */
	public function listar($aceito = false) {

		$q = "
			SELECT projeto.nome as projetonome,
			       projeto.id as idprojeto,
				   CONCAT(usuario.nome, ' ', usuario.sobrenome) as usuarionome,
				   inclusao.id as id
				 FROM projeto,inclusao,usuario
				 WHERE projeto.id = inclusao.idprojeto
				 AND projeto.idusuario = usuario.id
				 AND inclusao.idusuario = $this->idusuario
		";
		if(is_int($aceito)): $q .= " AND inclusao.aceito = {$aceito}"; endif;

		return $this->mysql->query($q);

	}


	/*
		Aceita ou não 
	*/
	public function aprovar($data) {

		$ativo = ($data["aceitar"] == "true");
		$id = $data["id"];

		$this->retorno = $data["aceitar"];

		if($ativo == true):
			/*
				Update na lina
			*/
			$q = "UPDATE $this->tabela SET aceito=1 WHERE idusuario = $this->idusuario AND id = $id";
			// $this->retorno = $q;

			if($this->mysql->atualizar($q)):
				$this->retorno = "Aceitado com sucesso";
			endif;

		else:

			$q = "DELETE FROM $this->tabela WHERE idusuario = $this->idusuario AND id = $id";
			
			// $this->retorno = $q;
			
			if($this->mysql->excluir($q)):
				$this->retorno = "Recusado com sucesso!";
			endif;
		endif;

	}
	public function salvarPermissoes($data) {

		$array = array(
			"comentario"=> (isset($data['comentario'])) ? 1 : 0,
			"anexo" => (isset($data['anexo'])) ? 1 : 0,
			"referencia" => (isset($data['referencia'])) ? 1 : 0,
			"pdf" => (isset($data['pdf'])) ? 1 : 0,
			"topico" => (isset($data['topico'])) ? 1 : 0,
			"notas"=>(isset($data['notas'])) ? 1 : 0
			);
		$array = $this->mysql->arrayTo($array,"update");

		$q = "UPDATE $this->tabela SET $array WHERE idusuario = {$data['idusuario']} AND idprojeto = $this->projeto";

		if( $this->mysql->atualizar($q) ):
			$this->retorno = "Permissões atualizadas com sucesso!";
		endif;
	}

	public function excluir($data) {

		$q = "DELETE FROM $this->tabela WHERE idusuario = {$data['idusuario']} AND idprojeto = $this->projeto";

		if($this->mysql->excluir($q)):
			$this->retorno = "Usuário excluído com sucesso!";
		endif;

	}

}
?>