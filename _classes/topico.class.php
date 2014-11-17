<?php

class Topico {

	private $tabela = "topico";
	protected $mysql;
	protected $projetoID = null;
	protected $usuarioID;

	public function __construct() {
		 $db = new mysql;
		 $this->mysql = $db;
	}
	public function setProjeto($p) {
		$this->projetoID  = $p;
	}
	public function setUsuario($u) {
		$this->usuarioID  = $u;
	}
	public function getProjeto() {
		return $this->projetoID;
	}
	public function getUsuario() {
		return $this->usuarioID;
	}
	
	static public function getTabela() {
		return $this->tabela;
	}

	public function listar($n,$pai = null) {
		// Query
		$q = "SELECT * FROM $this->tabela WHERE idprojeto='$this->projetoID' AND nivel=$n";
		if($pai !== null) {
			$q .= " AND idpai=$pai"; 
		}
		$q .= " ORDER BY ordem,id";
		return $this->mysql->query($q);
	}

	public function existe($n,$pai=false){
		if(!$pai) {
			$var = "idpai IS NULL";
		}else {
			$var = "idpai=$pai";
		}
		$q = "SELECT id from $this->tabela WHERE idprojeto=$this->projetoID AND nivel=$n AND ".$var;
		return $this->mysql->existe($q);
	}

	public function cadastrar($titulo,$n,$idpai=null) {
		$n = $n + 1;

		$e = "SELECT * FROM $this->tabela WHERE idprojeto=$this->projetoID AND ";
		$e .= ($idpai == "null") ? "idpai IS NULL" : "idpai=".$idpai;
		
		$ordem = $this->mysql->contar($e) + 1;

		$q = "INSERT INTO $this->tabela (idprojeto,titulo,data,hora,ordem,nivel,idpai) ";
		$q .= "VALUES ($this->projetoID,'$titulo',CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP(),$ordem,$n,".$idpai.")";
		if($this->mysql->inserir($q)) {
			return true;	
		}else {
			return false;
		}
		// return $q;
	}

	public function dataSalvamento($id) {
		$q = "SELECT data,hora FROM $this->tabela WHERE id=$id";
		return $this->mysql->listar($q);
	}

	public function atualizar($id,$html) {
		$q = "UPDATE $this->tabela SET html='$html',data=CURRENT_TIMESTAMP(), hora=CURRENT_TIMESTAMP() WHERE id=$id";
		if( $this->mysql->atualizar($q) ) {
			return true;
		}else {
			return false;
		}
	}
	public function pegarHtml($id) {
		$q = "SELECT html,data,hora FROM $this->tabela WHERE id=$id";
		return $this->mysql->listar($q);
	}
	public function renomear($id,$titulo) {
		$q = "UPDATE $this->tabela SET titulo='$titulo' WHERE id=$id";
		if( $this->mysql->atualizar($q) ) {
			return true;
		}else {
			return false;
		}
	}

	public function reordenar($ordem) {
		$c = 1;
		$ordem = explode(",",$ordem);
		$n = count($ordem)-1;
		$t = "";

		$q = "";
		for ($i=0;$i<=$n;$i++) {
			$q = "UPDATE $this->tabela SET ordem=$c WHERE id=".$ordem[$i];
			$this->mysql->atualizar($q);
			$c++;
		}
		if(($c-1) === ($n+1)) {
		 	return true;
		}else{
		 	return false;
		}
	}

	public function excluir($id) {

		// Pega suas informações principais
		$q = "SELECT * FROM $this->tabela WHERE id=$id AND idprojeto=$this->projetoID";
		$info = $this->mysql->listar($q);

		// Verifica se este tópico possui filhos
		$q = "SELECT * FROM $this->tabela WHERE idpai=$id AND idprojeto=$this->projetoID";
		$filhos = $this->mysql->existe($q);

		// Verifica se o tópico possui irmãos maiores
		$idpai = ($info["idpai"] == null) ? "idpai IS NULL" : "idpai=".$info["idpai"];

		$q = "SELECT * FROM $this->tabela WHERE $idpai AND idprojeto=$this->projetoID AND id != ".$info["id"]." AND ordem > ".$info["ordem"];
		$irmaosMaiores = $this->mysql->existe($q);
		
		if(!$filhos && !$irmaosMaiores) {
			$q = "DELETE FROM $this->tabela WHERE id=$id AND  idprojeto=$this->projetoID";
			if($this->mysql->excluir($q)) {
				return $info["titulo"]." removido com sucesso";
			}
		}
		if($irmaosMaiores){
			
			$query = $this->mysql->query($q);
			foreach($query as $linha) {
				$decremento = $linha["ordem"] - 1;
				$mid = $linha["id"];
				$nq = "UPDATE $this->tabela SET ordem=$decremento WHERE id=$mid";
				$this->mysql->atualizar($nq);
			}
			$q = "DELETE FROM $this->tabela WHERE id=$id AND idprojeto=$this->projetoID";
			$this->mysql->excluir($q);
		}
		if($filhos) {
			$q = "DELETE FROM $this->tabela WHERE idpai=$id";
			$this->mysql->excluir($q);
		}
		return true;
	}

}

?>