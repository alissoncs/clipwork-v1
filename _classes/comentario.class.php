<?php
// Comentários

class Comentario {

	private $projetoID;
	private $usuarioID;
	private $comentarioID;
	private $tabela = "comentario";
	private $vstabela = "visualiza_comentario";
	private $mysql;
	private $count;

	public function __construct($id) {
		$this->projetoID = $id;	
		$this->mysql = new mysql;
	}
	public function getNumComentarios() {
		return $this->count;
	}

	public function setIdComentario($id) {
		return $this->comentarioID = $id;
	}

	public function getProjetoID() {
		return $this->projetoID;
	}
	public function getUsuarioID() {
		return $this->usuarioID;
	}
	public function setProjetoID($a) {
		$this->projetoID = $a;	
	}
	public function setUsuarioID($a) {
		$this->usuarioID = $a;	
	}
	static public function getTabela() {
		return $this->tabela;
	}
	public function novo($post) {
		$q = "INSERT INTO $this->tabela (idprojeto,idusuario,nomeusuario,titulo,html,data,hora) VALUES ";
		$q .= "($this->projetoID,".$post['idusuario'].",'".$post['nomeusuario']."','".$post['titulo']."','".encodeEditor($post['html'])."',CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP())";
		if($this->mysql->inserir($q)) :
			return true;
		else:
			return false;
		endif;
	}
	public function listar() {

		$q = "SELECT * FROM $this->tabela WHERE idprojeto = $this->projetoID ORDER BY id desc";
		$this->count = $this->mysql->contar($q);
		return $this->mysql->query($q);
	}

	public function getComentario($id,$limit = false) {
		if($limit):
			$q = "SELECT $this->tabela.* FROM $this->tabela WHERE idprojeto=$this->projetoID ORDER BY id desc LIMIT 1";
			return ($this->mysql->existe($q)) ? $this->mysql->listar($q) : false;
		else:
			//$b = "(SELECT COUNT(1) FROM $this->vstabela WHERE idusuario=$this->usuarioID)";
			$q = "SELECT * FROM $this->tabela WHERE idprojeto = $this->projetoID AND id = $id";
			return $this->mysql->listar($q);	
		endif;
		
	}
	public function excluir($id) {
		$q = "DELETE FROM $this->tabela WHERE id=$id";
		return $this->mysql->excluir($q);
	}

	private function visualizaComentario($idcomentario) {
		// Verifica se o usuario já visualizou
		$v = "SELECT COUNT(*) AS VISUALIZADO FROM $this->vstabela WHERE idusuario = $this->usuarioID AND ";
	}

}



?>