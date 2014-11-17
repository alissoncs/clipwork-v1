<?php 

class Referencia {

	protected $idprojeto;
	protected $mysql;
	private $tabela = "referencia";

	public function __construct() {
		$db = new mysql;
		$this->mysql = $db;
	}
	public function setProjetoID($projetoID) {
		$this->idprojeto = $projetoID;
	}
	public function setTipo($tipo) {
		$this->tipo = $tipo;
	}
	public function getTipo() {
		return $this->tipo;
	}
	static public function getTabela() {
		return $this->tabela;
	}
	public function cadastrar($post) {
		$tipo = $this->getTipo();

		$titulo = $post["titulo"];
		$nomeautor1 = $post["nomeautor1"];
		$sobrenomeautor1 = $post["sobrenomeautor1"];
		$nomeautor2 = $post["nomeautor2"];
		$sobrenomeautor2 = $post["sobrenomeautor2"];
		$maisautores = (isset($post["maisautores"])) ? "1" : "0"; 
	
	// WEB		
		$url = $post["url"];
		$dataacesso = $post["dataacesso"];

	// LIVRO

		$editora = $post["editora"];
		$edicao = $post["edicao"];
		$datalancamento = $post["datalancamento"];
		$local = $post["local"];
		$paginalivro = $post["paginalivro"];
		$traducao = $post["traducao"];

	// ARTIGO
		$artigocaderno = $post["artigocaderno"];
		// $paginalivro = $post["paginalivro"];
	// OUTRO
		$html = $post["outro"];

		switch($tipo) {
			case "web":
				$q = "INSERT INTO $this->tabela (idprojeto,tipo,titulo,nomeautor1,nomeautor2,sobrenomeautor1,sobrenomeautor2,maisautores,url,dataacesso) VALUES ";
				$q .= "($this->idprojeto,'$tipo','$titulo','$nomeautor1','$nomeautor2','$sobrenomeautor1','$sobrenomeautor2','$maisautores','$url','$dataacesso')";
			break;
			case "livro":
				$q = "INSERT INTO $this->tabela (idprojeto,tipo,titulo,nomeautor1,nomeautor2,sobrenomeautor1,sobrenomeautor2,maisautores,editora,datalancamento,local,traducao,paginalivro,edicao) VALUES ";
				$q .= "($this->idprojeto,'$tipo','$titulo','$nomeautor1','$nomeautor2','$sobrenomeautor1','$sobrenomeautor2','$maisautores','$editora','$datalancamento','$local','$traducao','$paginalivro','$edicao')";
			break;
			case "artigo":
				$q = "INSERT INTO $this->tabela (idprojeto,tipo,titulo,nomeautor1,nomeautor2,sobrenomeautor1,sobrenomeautor2,maisautores,editora,datalancamento,local,traducao,paginalivro,artigocaderno,edicao) VALUES ";
				$q .= "($this->idprojeto,'$tipo','$titulo','$nomeautor1','$nomeautor2','$sobrenomeautor1','$sobrenomeautor2','$maisautores','$editora','$datalancamento','$local','$traducao','$paginalivro','$artigocaderno','$edicao')";
			break;
			case "outro":
				$q = "INSERT INTO $this->tabela (idprojeto,tipo,html) VALUES ";
				$q.= "($this->idprojeto,'$tipo','$html')";
			break;
		}

		return $this->mysql->inserir($q);

	}
	public function listar($tipo=null) {
		if(!$tipo) {
			$q = "SELECT * FROM $this->tabela WHERE idprojeto=$this->idprojeto ORDER BY id DESC";	
		}else {
			$q = "SELECT * FROM $this->tabela WHERE idprojeto=$this->idprojeto AND tipo=$tipo ORDER BY id DESC";
		}
		$query = $this->mysql->query($q);
		if($this->mysql->existe($q)) {
			return $query;
		}else {
			return false;
		}
	}

	public function atualizar($post) {
		$tipo = $this->getTipo();

		$id = $post["id"];

			$titulo = $post["titulo"];
		$nomeautor1 = $post["nomeautor1"];
		$sobrenomeautor1 = $post["sobrenomeautor1"];
		$nomeautor2 = $post["nomeautor2"];
		$sobrenomeautor2 = $post["sobrenomeautor2"];
		$maisautores = (isset($post["maisautores"])) ? "1" : "0"; 
	
	// WEB		
		$url = $post["url"];
		$dataacesso = $post["dataacesso"];

	// LIVRO

		$editora = $post["editora"];
		$edicao = $post["edicao"];
		$datalancamento = $post["datalancamento"];
		$local = $post["local"];
		$paginalivro = $post["paginalivro"];
		$traducao = $post["traducao"];

	// ARTIGO
		$artigocaderno = $post["artigocaderno"];

	// OUTRO
		$html = $post["outro"];
		$q = "UPDATE $this->tabela SET ";
		switch($tipo) {
			case "web":
				$q .= "tipo='$tipo',titulo='$titulo',nomeautor1='$nomeautor1',nomeautor2='$nomeautor2',sobrenomeautor1='$sobrenomeautor1',sobrenomeautor2='$sobrenomeautor2',maisautores='$maisautores',url='$url',dataacesso='$dataacesso'";
			break;
			case "livro":
				$q .= "tipo='$tipo',titulo='$titulo',nomeautor1='$nomeautor1',nomeautor2='$nomeautor2',sobrenomeautor1='$sobrenomeautor1',sobrenomeautor2='$sobrenomeautor2',maisautores='$maisautores',editora='$editora',datalancamento='$datalancamento',local='$local',traducao='$traducao',paginalivro='$paginalivro',edicao='$edicao'";
			break;
			case "artigo":
				$q .= "tipo='$tipo',titulo='$titulo',nomeautor1='$nomeautor1',nomeautor2='$nomeautor2',sobrenomeautor1='$sobrenomeautor1',sobrenomeautor2='$sobrenomeautor2',maisautores='$maisautores',editora='$editora',datalancamento='$datalancamento',local='$local',traducao='$traducao',paginalivro='$paginalivro',artigocaderno='$artigocaderno',edicao='$edicao'";
			break;
			case "outro":
				$q .= "tipo='$tipo',html='$html'";
			break;
		}
		$q.= " WHERE idprojeto=$this->idprojeto AND id=$id";

		return $this->mysql->atualizar($q);

	}
	public function remover($id) {
		$q = "DELETE FROM $this->tabela WHERE id=$id";
		return $this->mysql->excluir($q);
	}

} // fecha classe
?>