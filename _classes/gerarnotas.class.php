<?php

class GerarNotas extends mPDF{

	private $status = false;

	private $capa = null;
	private $nome;

	private $projetoID = null;

	private $mysql;

	public $gerartrabalho = null;

	/**
	 * Configurações
	 */
	private $config = array();

	public function setConfig($post) {
		$this->config = array(
			"visualizar"=> isset($post['download']) ? "D" : "I",
			"capa" => isset($post['capa']),
			"inativas"=>isset($post['inativas'])
		);
	}
	public function getConfig() {
		return $this->config;
	}

	public function geraSelect($data = null) {
		$this->select = "SELECT * FROM notas WHERE idprojeto = $this->projetoID ";
		if($this->config['inativas'] == false) $this->select .= " AND ativo = 1";

		$this->WriteHTML($this->select);
	}

	public function notas($tipo = 1) {

		$select = $this->select;

		$query = $this->mysql->query($select);

		$counter = 0;

		foreach ($query as $linha):
			$counter = $counter + 1;

			$titulo = $linha['assunto'];

			$titulo = $this->gerartrabalho->_html($counter." - ".$titulo,"span","negrito;maiusculo");

			$data = $this->gerartrabalho->formataData($linha['data'],"/");

			$texto = $this->gerartrabalho->tratarHtml($linha['texto']);

			$this->WriteHTML( $data ." - ".$titulo );
			$this->WriteHTML("<br>");

			$this->WriteHTML($texto);
			$this->WriteHTML("<br>");
		endforeach;

	}
	public function setProjetoID($projetoID){
		$this->projetoID = $projetoID;
	}

	public function getStatus() {
		return $this->status;
	} 

	public function setMysql() {
		$this->mysql = new mysql;
	}

	public function _criar($a = null) {

		if($this->projetoID == null) return false;
 
		$this->allow_charset_conversion=true;
		$this->charset_in='UTF-8';

		$this->setMysql();

		$this->gerartrabalho = new GerarTrabalho();
		
		$this->gerartrabalho->setMysql();

		$this->gerartrabalho->setProjetoID($this->projetoID);

		if($this->config['capa'] == true):
			$this->gerartrabalho->capa("Anotações - Caderno de campo");
			$this->WriteHTML($this->gerartrabalho->capa);
		endif;

		$this->geraSelect();
		$this->notas();

		$this->Output("notas",$this->config['visualizar']);

	}


}

?>