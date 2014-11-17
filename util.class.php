<?php

/*
    Inclui o arquivo de configurações
*/
include dirname(__FILE__)."/config.php";

function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
}

function reduzirTexto($texto,$string=28) {
	 if (strlen($texto) > $string) {  
	 	if ( preg_match('/\s/',$texto) ) {
        	while (substr($texto,$string,1) <> ' ' && ($string < strlen($texto))){  
            	 $string++;  
        	}  
        }
        return substr($texto,0,$string)."...";  
     }else {
     	return $texto;
     }
}

// DATA
function dataPara($d) {
	// $data = explode('/',$datapega);
	// $datacerta = $data[2].'-'.$data[1].'-'.$data[0];
	return $d;
	// return $datacerta;
}

function dataDe($d) {
	$data = explode('-',$d);
	$d = $data[2].'/'.$data[1].'/'.$data[0];
	return $d;
}
    function ajustaHora($valor=null) {
        $valor = explode(":",$valor);
        $valor = $valor[0].":".$valor[1];
        return $valor;
    }   

function encodeEditor($var) {
    return htmlentities($var, ENT_QUOTES);
}
function decodeEditor($html) {
    // $html = html_entity_decode($html);
    // $html = utf8_decode($html);
    // return mb_convert_encoding($html, "UTF-8", "HTML-ENTITIES");
    return html_entity_decode($html, ENT_QUOTES);
}

class Util {
    /* Atributo auxiliar
    */
    static private $aux = null;

    

    /*
        Limpa conteúdo malicioso dos parametros POST
    */
    public static function sanitize($post) {
        return $post;
        // if(gettype($post) == "array") {
        //     return filter_var_array($post,FILTER_SANITIZE_STRING); 
        // }
        // return filter_var($post,FILTER_SANITIZE_STRING); 
    }


    /*
        Criptografia em md5 e sha1
    */
    public static function cript($var) {
        return md5(sha1($var));
    }


    /*
        Retorna a data atual
    */

    public static function data() {
        date_default_timezone_set('Brazil/East');
        return array("data"=> date('d/m/Y', time()),"hora"=>date('h:i', time()) );
    }

    private static function getState() {
    }

    

    /*
        Importa alguma classe
    */
    protected static function importa($dir) {
        if(file_exists($dir)) {
            include($dir);
        }else {
            echo "<strong>Classe não encontrada</strong>";
            echo $dir."<br>";
        }
    }

    /*
        Cria um redirecionamento utilizando a função header
    */

    public static function header($var) {
        $root = URL;

        if(strpos($var,"?") == false && strpos($var,"=") == false && strpos($var,".php") == false):
            $var .= ".php";
        endif;
            ob_start();
            header("Location: ".$root.$var);
        exit;
    }


    /*

        Seta ou exibe mensagem via seção.

    */
    public static function mensagem($mensagem = null) {
        if($mensagem != null):
            /*
                Seta a mensagem na variavel de secao
            */
            Secao::variavel("mensagem",$mensagem);
            return true;

        else:

            /*
                Exibe a mensagem via Javascript
            */
            if(Secao::get("mensagem") != null):
                $msg = Secao::get("mensagem");
                Secao::limpa("mensagem");

                echo "
                <script type=\"text/javascript\">
                $(function(){
                    alertModal(\"Notificação\",\"".$msg."\");
                });
                </script>
                ";
            endif;

        endif;
    }


    /*
        Retorna navegador atual
    */
    protected static function getNavegador() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser        =   "browser";
        $browser_array  =   array(
                            '/msie/i'       =>  'ie',
                            '/firefox/i'    =>  'firefox',
                            '/safari/i'     =>  'safari',
                            '/chrome/i'     =>  'chrome',
                            '/opera/i'      =>  'opera',
                            '/netscape/i'   =>  'netscape',
                            '/maxthon/i'    =>  'mathon',
                            '/konqueror/i'  =>  'konqueror',
                            '/mobile/i'     =>  'handheldbrowser'
                        );

        foreach ($browser_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $browser    =   $value;
            }
        }
        return $browser;

    }


    /*
        Retorna o sistema operacional atual
    */
    protected static function getOs() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform    =   "Desconhecido";
        $os_array       =   array(
                                '/windows nt 6.3/i'     =>  'win8-1',
                                '/windows nt 6.2/i'     =>  'win8',
                                '/windows nt 6.1/i'     =>  'win7',
                                '/windows nt 6.0/i'     =>  'win-vista',
                                '/windows nt 5.2/i'     =>  'win-server',
                                '/windows nt 5.1/i'     =>  'win-xp',
                                '/windows xp/i'         =>  'win-xp',
                                '/windows nt 5.0/i'     =>  'win-2000',
                                '/windows me/i'         =>  'win-me',
                                '/win98/i'              =>  'win-98',
                                '/win95/i'              =>  'win-95',
                                '/win16/i'              =>  'win-311',
                                '/macintosh|mac os x/i' =>  'mac-os-x',
                                '/mac_powerpc/i'        =>  'mac-os-9',
                                '/linux/i'              =>  'linux',
                                '/ubuntu/i'             =>  'ubuntu',
                                '/iphone/i'             =>  'iphone',
                                '/ipod/i'               =>  'ipod',
                                '/ipad/i'               =>  'ipad',
                                '/android/i'            =>  'android',
                                '/blackberry/i'         =>  'blackberry',
                                '/webos/i'              =>  'mobile'
                            );
        foreach ($os_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }
        }   
        return $os_platform;
    }

    /*
        Verifica se o dispositivo é touchscreen (mobile device)
    */

    protected static function isTouch() {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $useragents = array (
            "iPhone",
            "iPod",
            "iPad",
            "Android",
            "blackberry9500",
            "blackberry9530",
            "blackberry9520",
            "blackberry9550",
            "blackberry9800",
            "webOS"
            );
            $result = false;
        foreach ( $useragents as $useragent ) {
            if (preg_match("/".$useragent."/i",$agent)) {
                $result = true;
                break;
            }
        }
        return $result;
    }


}



class Secao extends Util {

    public static function criar() {
        if(session_status() == PHP_SESSION_NONE):
            session_start();
        endif;
    }
    public static function excluir() {
        self::criar();
        self::limpa();
        session_destroy();   
    }
    public static function variavel($var,$valor) {
        $_SESSION[$var] = $valor;
        return true;
    }
    public static function limpa($var = null) {
        if(isset($var) && isset($_SESSION[$var])):
            unset($_SESSION[$var]);
        else:
            session_unset();
        endif;
        return true;
    }
    public static function get($var = null) {
        if(isset($var)):
            return (isset($_SESSION[$var])) ? $_SESSION[$var] : null;
        endif;
        return $_SESSION;
    }
    public static function status() {
        if(self::get("idusuario") != null):
            return true;
        endif;
        return false;
    }

}




class Includes extends Util {
    private static $current = "";

    // Importa todas as classes do diretório de classes
    
    public static function modelo($var) {

        $caminho = MODEL."/".$var.".class.php";
        self::importa($caminho);

    }

    // Importa o cabeçalho
    public static function getHead() {
        include ROOT."/html_head.php";
    }
    public static function getHeader() {
        include ROOT."/html_header.php";
    }
    public static function getFooter() {
        include ROOT."/html_footer.php";
    }
}





class Helper extends Util {

    public static function link($filename,$format=null){
        if($format == null) $format = "css";
        echo "<link href='{$format}/{$filename}.{$format}' rel='stylesheet' type='text/css'/>";
    }

}








class Fluxo extends Util {
    public static function cript($var) {
        return md5(sha1($var));
    }
    public static function classe($nome) {
        if (!class_exists(ucfirst($nome))):
            Includes::modelo($nome);
        endif;
    }
    public static function db() {
        Includes::modelo("db");
    }

    public static function bodyClass() {
        $touch = (parent::isTouch()) ? " touch" : null;

        return parent::getOs()." ".parent::getNavegador().$touch;
    }

    public static function bodyId() {
        global $actual;
        $actual = (isset($actual)) ? $actual : null;
        $bn = basename($_SERVER["SCRIPT_FILENAME"], '.php');

        if(empty($_GET)) :
            $m = $bn;
        else:
            $get = null;
            $get = (isset($_GET["pg"])) ? $_GET["pg"] : $get;

            if ($actual !== null) : $get = $actual ; endif;

            $m = $get;
        endif;
        return "pg-".$m;
    }


    // Executa função através do parâmetro da URL
    public static function executarF() {
        if(isset($_GET["f"])):

            Secao::criar();

            $act = $_GET["f"];
            if(function_exists($act)) {
                $act();
            }
        endif;
    }

    /*
        Trabalha com ID_PROJETO
    */
    public static function idprojeto() {
        if(defined("ID_PROJETO")):
            return ID_PROJETO;
        endif;
        if(isset($_POST["idprojeto"])):
            return $_POST["idprojeto"];
        endif;
    }

}



?>