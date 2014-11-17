<?php
class db {
	private $host = "localhost";
	private $dbname = "clipwork";
	public $user = "root";
	private $pass = "";
	protected $c;

	// private $host = "mysql.hostinger.com.br";
	// private $dbname = "u511061986_acs";
	// public $user = "u511061986_acs";
	// private $pass = "jusduct32C";
	// protected $c;

	public function __construct() {
		$this->connect();
	}
	protected function connect(){
		$this->c = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);
	}
	protected function disconnect() {
		mysqli_close($this->c);
		return true;
	}
}
class mysql extends db {
	private $query = "";
	protected $c;
	private $now;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() {
		parent::disconnect();
	}

	public function query($query,$bool = false) {
		mysqli_set_charset($this->c,'utf8');
		$r = mysqli_query($this->c, $query);

		if($bool): return $r; endif;
		
		if(gettype($r) != "boolean" && mysqli_num_rows($r) !== 0 && $r):
			return $r;
		endif;			
			return false;
	}
	// Função SELECT LISTA EM ARRAY
	public function listar($query) {
		$b = $this->query($query);
		if(gettype($b) != "boolean"):
			return mysqli_fetch_assoc( $b );	
		endif;
		return false;
		
	}

	// Função conta resultados
	public function contar($query,$end=false) {
		$q = $this->query($query);
		if(gettype($q) == "boolean"):
			return 0;
		endif;

		return mysqli_num_rows( $this->query($query) );
	}

	// Função Verifica se existe algo na tabela
	public function existe($query,$end=false) {
		if( $this->contar($query) !== 0 ) {
			return true;
		}else {
			return false;
		}
	}
	
	public function inserir($query) {
		if ($this->query($query,true)) {
			return true;
		}
	}

	// Função ATUALIZAR dados
	public function atualizar($query) {
		if ($this->query($query,true)) {
			return true;
		}
	}

	// Método eliminar
	public function excluir($query) {
		if ($this->query($query,true)) {
			return true;
		}
	}

	public function getId() {
		return mysqli_insert_id($this->c);
	}

	public function arrayTo($array, $tipo="update") {
		/*
			Converte array para query
		*/

			$countArray = count($array);
			$string = "";

			$aux = 0;

	if($tipo == "update"):
		foreach($array as $key => $value) {

			$aux++;

			if(gettype($value) == "string" && $value != "CURRENT_TIMESTAMP()") {
				$value = "'".$value."'";
			}

			$string .= $key."=".$value;
			if($aux != $countArray):

				$string .= ",";	
			endif;

		}

		/* caso seja insert */
	else:

		$string .= "(";

		foreach($array as $key => $value) {

			$aux++;

			$string .= $key;
			if($aux != $countArray):
				$string .= ",";	
			endif;

		}

		$aux = 0;

		$string .= ") VALUES (";

		foreach($array as $key => $value) {

			$aux++;

			if(gettype($value) == "string" && $value != "CURRENT_TIMESTAMP()") {
				$value = "'".$value."'";
			}

			$string .= $value;
			if($aux != $countArray):
				$string .= ",";	
			endif;

		}
		$string .= ")";


	endif;

	return $string;

	}

	/*
		Insere informações na tabela de LOG
	*/
		public function logprojeto($id,$mensagem) {
			return $this->inserir("INSERT INTO log_projeto (idprojeto,mensagem) VALUES ($id,'$mensagem')");
		}

}

?>