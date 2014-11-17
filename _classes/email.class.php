<?php

class Email {
	/**
	 * Classe para envio de e-mails
	 */
	
	private $text = "";
	public $status = false;
	private $para = null;

	/**
	 * Classe construtura
	 * @param [type] $var [description]
	 */
	public function __construct($var) {

		$status = true;

	}
	/**
	 * Seta variável de texto
	 * @param [type] $text [description]
	 */
	public function set($text) {
		$this->text = $text;
	}
	public function para($email) {
		$this->para = $email;
	}

	/**
	 * Método para envio de e-mail
	 * @return [bool] [status de envio]
	 */
	public function send() {

		/**
		 * Método para envio de e-mail
		 */
		
		return true;

	}


}

?>