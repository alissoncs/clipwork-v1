<?php

class MenuProjeto extends Projeto {

	private $item = "teste";

	protected $idprojeto;

	private $url = "projeto.php?id=";

	private $current;

	/* Armazena o arquivo do menu */
	private $menucompleto = "";

	private $permissao;


	/* Métodos */
	public function getItem() {
		return $this->item;
	}
	public function current($cur) {
		$this->current = $cur;
	}
	public function __construct($idprojeto) {
		$this->idprojeto = $idprojeto;

		$this->url .= $this->idprojeto."&editar=";

		$this->permissao = $GLOBALS['permissao'];
	}

	protected function getID() {
		return $this->idprojeto;
	}
	public function getUrl($link = null) {
		if($link != null):
			return $this->url . $link;
		endif;

		return $this->url;
	}

	public function item($titulo,$link,$icon=null,$descricao=null) {

		/*
			Página atual
		*/
	if( !isset($this->permissao[$link]) || $this->permissao[$link] > 0 ):

		$class = ($this->current == $link) ? " active" : null;

		if($descricao == null) $descricao = $titulo;

		$var =  "<li class='item-{$link}{$class}'>";

		if($this->current != $link)	$var .= "<a href='{$this->url}{$link}' title='{$descricao}' aria-label='{$descricao}'>";

		if($this->current == $link)	$var .= "<a href='javascript:void(0)' title='{$descricao}' aria-label='{$descricao}'>";

		if($icon != null):
			$var .= "<i class='fa fa-{$icon}'></i>";
		endif;

		$var .= "{$titulo}";

		$var .= "</a>"; 

		$var .= "</li>";

		$this->menucompleto .= $var;

	endif;

	}

	public function navegacao() {
		echo $this->menucompleto;
	}

	public function mobileNav() {

		/*
			Mostra menu em formato mobile;
		*/
	if($this->menucompleto != null):
		echo "<span class='easy easy-menu visible-inline-block-xs visible-inline-block-sm' id='mobile-nav-projeto' aria-haspopup='true' aria-expanded='false' aria-label='Menu de navegação'>";
		echo "<a href='#' data-toggle='dropdown' title='Expandir menu de navegação'>";
		echo "<i class='fa fa-navicon'></i></a>";
		echo "<ul class='dropdown-menu dropdown-menu-right' role='menu' aria-labelledby='Menu configurações'>";
		echo $this->menucompleto;
		echo "</ul>";
		echo "</span>";
	endif;

	}

}

?>