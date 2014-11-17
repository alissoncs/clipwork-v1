<?php

class Notas {
	private $tabela = "notas";
	protected $mysql;
	private $idprojeto;
	private $idusuario;

	// DB
	private $c_idprojeto = "idprojeto";
	private $c_idautor = "idusuario";
	private $c_assunto = "assunto";
	private $c_texto = "texto";
	private $c_data = "data";
	private $c_hora = "hora";
	private $c_ativo = "ativo";

		public function __construct($u,$p) {
			$this->setProjeto($p);
			$this->setUsuario($u);
			 $db = new mysql;
			 $this->mysql = $db;
		}
		private function setProjeto($p) {
			$this->idprojeto  = $p;
		}
		private function setUsuario($u) {
			$this->idusuario  = $u;
		}

	static public function getTabela() {
		return $this->tabela;
	}

	/*
		Lista as notas
	*/
	public function listar($limite=null) {
	 	$q = "SELECT *,(SELECT nome FROM usuario WHERE idusuario=id) AS usuarioautor FROM $this->tabela WHERE $this->c_idprojeto=$this->idprojeto";
	 	$q.= " ORDER BY ID DESC";

	 	if(isset($limite)) {
			$q.= " LIMIT 0, $limite";	 		
	 	}

	 	if( $this->mysql -> existe($q) ) {
	 		return $this->mysql ->query($q);
	 	}else {
	 		return false;
	 	}
	}

	/*
		Cadastra uma nova da
	*/

	public function cadastrar($assunto,$texto) {
		$q = "INSERT INTO $this->tabela ($this->c_idprojeto,$this->c_idautor,$this->c_assunto,$this->c_texto,$this->c_data,$this->c_hora,$this->c_ativo) ";
		$q .= "VALUES ($this->idprojeto,$this->idusuario,'$assunto','$texto',CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP(),1)";

		$this->mysql->logprojeto($this->idprojeto,"Uma nova nota '{$assunto}' foi inserida");

		return $this->mysql->inserir($q);
	}

	/*
		Arquiva ou ativa a nota
	*/
	public function toggle($idnota) {
		// a nota nao pode ser removida, e sim arquivada.
		$q = "UPDATE $this->tabela SET $this->c_ativo= CASE WHEN $this->c_ativo=1 THEN 0 ELSE 1 END WHERE id=$idnota";

		$this->mysql->logprojeto($this->idprojeto,"Uma nova nota foi arquivada");

		return $this->mysql->atualizar($q);
	}

}

?>