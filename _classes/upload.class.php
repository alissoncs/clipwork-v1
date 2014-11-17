<?php
class Upload {


	private $filename = "";
	private $create_folder;
	private $dir = "../cliente/";
	public $file_format;
	private $projetoID;
	private $mysql;
	private $root;

	public $src;

	public function __construct() {
		$this->mysql = new mysql;
	}
	public function setROOT($root) {
		$this->root = $root;
	}

	private function error($f) {
		switch ($f) { 
            case UPLOAD_ERR_INI_SIZE: 
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini"; 
                break; 
            case UPLOAD_ERR_FORM_SIZE: 
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form"; 
                break; 
            case UPLOAD_ERR_PARTIAL: 
                $message = "The uploaded file was only partially uploaded"; 
                break; 
            case UPLOAD_ERR_NO_FILE: 
                $message = "No file was uploaded"; 
                break; 
            case UPLOAD_ERR_NO_TMP_DIR: 
                $message = "Missing a temporary folder"; 
                break; 
            case UPLOAD_ERR_CANT_WRITE: 
                $message = "Failed to write file to disk"; 
                break; 
            case UPLOAD_ERR_EXTENSION: 
                $message = "File upload stopped by extension"; 
                break; 

            default: 
                $message = "Unknown upload error"; 
                break; 
        } 
        return $message;
	}

	public function upload($campo) {
		$cond = true;
		$name = $_FILES[$campo]['name'];
		$f = explode(".",$name);
		$f = end($f);
		$name = sha1(date('m/d/Y h:i:s a', time())) . "-" . $this->projetoID . "_" . $f . "_." . $f;
		
		$uploadfile = $this->dir . $name;
		$this->createFolder($this->dir);

		if($f != "jpg" || $f == "png" || $f == "gif"):
			$cond = false;
		endif;

		if (move_uploaded_file($_FILES[$campo]['tmp_name'], $uploadfile) && $cond):
			$this->src = str_replace("../",URL,$uploadfile);
			return true;
		endif;

		return false;
	}
	public function delete($id,$nome) {
		return unlink($this->dir.$nome);
	}

	public function createFolder($name) {
		if($this->folderExists($name)):
			return mkdir($name, 0777, true);
		endif;
	}
	private function folderExists($dir) {
		if (!file_exists($dir)) {
    		return true;
		}
	}
	public function setFolder($folder) {
		$this->create_folder = $folder;
	}
	public function setProjetoID($id) {
		$this->projetoID = $id;
		$this->dir .= "p".$id."/";
	}
	public function getDir() {
		return str_replace("../", "",$this->dir);
	}
	public function isImg($s) {
		return ($s == "jpg" || $s == "png" || $s == "jpeg" || $s == "png" || $s == "gif") ? true : false;
	}
	private function imgResize($width, $height) {

	}
	private function insereMysql($nome,$info=null,$formato) {
		$q = "INSERT INTO arquivos (idprojeto, nome, descricao,formato) VALUES ($this->projetoID, '$nome', '$info','$formato')";
		 return $this->mysql->inserir($q);
		//return $q;
	}
	public function listar() {
		$q = "SELECT * FROM arquivos WHERE idprojeto = $this->projetoID ORDER BY id DESC";
		return ( $this->mysql->existe($q) ) ? $this->mysql->query($q) : false;
	}
	private function removeMysql($id=null,$nome=null) {
		if($id !== null) {
			$q = "";
		}else {
			if($nome !== null) {
				$q = "";
			}
		}
	}

}

?>