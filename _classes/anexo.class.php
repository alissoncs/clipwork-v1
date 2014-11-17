<?php 

	class Anexo {


		/*
			Classe para manipulação de anexos a apêndices
		*/

		private $tabela = "anexo";
		private $idprojeto;
		private $anexoid;
		private $contagem = 0;
		private $mysql;

		public function __construct() {
			 $db = new mysql;
			 $this->mysql = $db;
		}
		static public function getTabela() {
			return $this->tabela;
		}
		public function setProjetoID($id) {
			$this->idprojeto = $id;
		}
		public function setIdAnexo($id) {
			$this->anexoid = $id;
			return $id;
		}
		public function getContagem($tipo) {
			$q = "SELECT * FROM $this->tabela WHERE idprojeto = $this->idprojeto AND tipo = '$tipo'";
			$this->contagem = $this->mysql->contar($q);
			return $this->contagem;
		}
		public function listar($t = null) {
			$q = "SELECT * FROM $this->tabela WHERE idprojeto=$this->idprojeto ORDER BY tipo, ordem";
			if($this->mysql->existe($q)){
				return $this->mysql->query($q);
			}else {
				return false;
			}
			// return $q;
		}
		public function cadastrar($p) {

			$ordem = ( $p['tipo'] == "apendice" ) ? $p["apendice-ordem"] : $p["anexo-ordem"];
			$ordem++;

			$insert = array(
				"idprojeto"=>$this->idprojeto,
				"titulo"=>$p["titulo"],
				"html"=>$p['html'],
				"tipo"=>$p['tipo'],
				"ordem"=>$ordem
				);
			$query = "INSERT INTO $this->tabela ".$this->mysql->arrayTo($insert,"insert");
			return $this->mysql->inserir($query);

		}
		public function atualizar($id,$titulo,$html,$tipo,$oldtipo,$ordem) {
			if($tipo==$oldtipo) :
				$q = "UPDATE $this->tabela SET titulo='$titulo', html='$html' WHERE id=$id";
			else:
				// Caso mude o usuário altere o tipo
				$c = $this->getContagem($tipo) + 1;
				$q = "UPDATE $this->tabela SET titulo='$titulo', tipo='$tipo', ordem=$c WHERE id=$id";
			// Update others
				$update = "UPDATE $this->tabela SET ordem=ordem-1 WHERE idprojeto=$this->idprojeto AND ordem>$ordem AND tipo='$oldtipo'";	
				$this->mysql->atualizar($update);	
			endif;

			if($this->mysql->atualizar($q)) :
				return true;	
			endif;

		}
		public function excluir($id,$ordem,$tipo) {
			// Update nos itens maiores
			$update = "UPDATE $this->tabela SET ordem=ordem-1 WHERE idprojeto=$this->idprojeto AND ordem>$ordem AND tipo='$tipo'";
			$query = "DELETE FROM $this->tabela WHERE id=$id AND idprojeto=$this->idprojeto";
			if($this->mysql->excluir($query) && $this->mysql->atualizar($update)) : return true;
			else: return false; endif;
		}
		public function verifica() {
			$id = $this->anexoid;
			$q = "SELECT * FROM $this->tabela WHERE id=$id AND idprojeto=$this->idprojeto";
			if($this->mysql->existe($q)) : return true; endif;
		}
		public function getConteudo() {
			$q = "SELECT * FROM $this->tabela WHERE id=$this->anexoid AND idprojeto = $this->idprojeto";
			return $this->mysql->listar($q);
		}

	}
?>