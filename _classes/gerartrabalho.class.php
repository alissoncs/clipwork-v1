<?php

class GerarTrabalho extends mPDF {

	private $element;
	private $status = false;
	public $erro = "Ocorreu um erro desconhecido";
	public $html = "";
	public $pdf = true;
	// protected $url = "http://localhost/clipwork/";
	protected $url = "http://www.alissoncs.eti.br/clipwork/";
	
	
	private $mysql;
	private $projetoID = null;

	private $html_sumario = "";
	private $qtd_sumario = 0;

	public $filename;
	
	private $nr_num = 1;
	private $nr_content;
	private $nr_first;
	private $nr_last;

	/**
	 * [$identificacao dados de idenficacao (select)]
	 * @var array
	 */
	private $identificacao = array();
	public $capa;

	/**
	 * Configurações de exportação
	 * @var array
	 */
	private $config = array();

	/**
	 * Alfabeto em array
	 * @var array
	 */
	private $alfabeto = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');


	public function setMysql() {
		$this->mysql = new mysql;
	}
	
	/* get e set attr configuracaoes*/
	public function setConfig($post=null) {
		
		/* Parâmetros de configuração */
		$array = array(
			"visualizar"=> isset($post['download']) ? "D" : "I",
			"contracapa"=> isset($post['contracapa']),
			"resumo"=>isset($post['resumo']),
			"sumario"=>isset($post['sumario']),
			"anexos"=>isset($post['anexos']),
			"numeracao"=>isset($post['numeracao'])
		);
		$this->config = $array;

	}
	public function getConfig() {
		return $this->config;
	}

	private function setErro($erro) {
		if($erro !== null) {
			$this->erro = $erro;
		}
	} 
	public function getIdenficacao() {
		return $this->identificacao;
	}
	public function getErro() {
		return $this->error;
	}
		private function setStatus($status) {
			if($status !== null) {
				$this->status = $status;
			}
		}
		public function getStatus() {
			return $this->status;
		}
	private function setHTML($html) {
		$this->html .= $html;
	}
	private function clearHTML() {
		$this->html = "";	
	}
	public function getHTML() {
		return $this->html;
	}
	public function setProjetoID($projetoID) {
		$this->projetoID = $projetoID;
	}

	/*
	*	Funções HTML
	*	@return=string
	*/
	public function _br($count=false){
		if($count) {
			$r = "";
			for($i=1;$i<=$count;$i++) {
				$r .= "<br>";	
			}
		}else {
			$r = "<br>";
		}
		return $r;
	}
	public function _html($content,$tag,$style=false){
		if($tag) {
			if($style) {
				$r = "<".$tag." style='".$this->_css($style)."'>";	
			}else {
				$r = "<".$tag.">";	
			}

			$r .= $content;
			$r .= "</".$tag.">";
		}else {
			$r = $content;
		}
		return $r;
	}

	public function _css($style) {
		//if(strpos($style,";")) {
			$d = explode(';',$style);
			$c = count($d);
		//}
		$css="";
		for($i=0;$i<$c;$i++) {
			switch($d[$i]) {
				case "maiusculo": $css .= "text-transform:uppercase;"; break;
				case "negrito": $css .= "font-weight:bold;"; break;
				case "italico": $css .= "font-style:italic;"; break;
				case "sublinhado": $css .= "text-decoration:underline;"; break;
				case "tachado": $css .= ""; break;
				case "centralizado": $css .= "text-align:center;"; break;
				case "esquerda": $css .= "text-align:left;"; break;
				case "direita": $css .= "text-align:right;"; break;
				case "justificado": $css .= "text-align:justify;"; break;
				case "cor": $css .= "color:#ff0000;"; break;
				case "floatleft": $css .= "float:left;"; break;
				case "floatright": $css .= "float:right;"; break;
				case "zeramargem": $css .= "margin:0;"; break;
			}
		}
		return $css;
	}
	public function formataData($data,$tipo=true,$g=null) {
		$data = filter_var($data, FILTER_SANITIZE_STRING);
		$data = explode('-',$data);

		if($tipo == true || $tipo == 1) :
			$array = array(
				"01" => "jan.",
				"02" => "fev.",
				"03" => "mar.",
				"04" => "abr.",
				"05" => "maio.",
				"06" => "jun.",
				"07" => "jul.",
				"08" => "ago.",
				"09" => "set.",
				"10" => "out.",
				"11" => "nov.",
				"12" => "dez."
			);	

		$data[1] = $array[$data[1]];
		endif;

		if($tipo == 2):
			$array = array(
				"01" => "Janeiro",
				"02" => "Fevereiro",
				"03" => "Março",
				"04" => "Abril",
				"05" => "Maio",
				"06" => "Junho",
				"07" => "Julho",
				"08" => "Agosto",
				"09" => "Setembro",
				"10" => "Outubro",
				"11" => "Novembro",
				"12" => "Dezembro"
			);
		$data[1] = $array[$data[1]];
		endif;
	

		$s = ($tipo) ? "&nbsp;" : "/";

		$d = $data[2].$s.$data[1].$s.$data[0];

		if($g !== null) : 
			$var = $data[$g];
		else : 
			$var = $d;
		endif;

		return $var;
	}
	private static function preg_trim($var) {
	    return var_dump(trim($var));
	}
	public function tratarHtml($html,$etapas = true) {
		 $html = html_entity_decode($html, ENT_QUOTES);

		 $this->nr_first = $this->page;

	// Etapas 
	if($etapas == true):

	// Adiciona borda nas tabelas e corrige alguns erros.
	$html = str_replace("<table style=\"","<table style=\"border-left:1px solid #000;border-top:1px solid #000;",$html);
	$html = str_replace("<td>","<td style=\"border-bottom:1px solid #000;border-right:1px solid #000;\">",$html);
	$html = str_replace("<td style=\"","<td style=\"border-bottom:1px solid #000;border-right:1px solid #000;",$html);
	$html = str_replace("<th>", "<th style=\"border-bottom:1px solid #000;\">", $html);

	// Adiciona url completa as imagens
	 $html = str_replace("<img src=\"","<img src=\"".ROOT,$html);
	// $this->setNotaRodape($html);

	endif;
	return $html;

	}
public function capa($tituloadd=null) {

	// Pega as informações da tabela detalhes

	$q = "SELECT * FROM projeto WHERE id=$this->projetoID";
	$this->identificacao = $this->mysql->listar($q);

	$db = $this->identificacao;

	// Seta início de página (sem numeração)
	$this->AddPage('','','','','on');

	$db["entidade"] = $this->_html($db["entidade"],"p","centralizado;maiusculo;negrito");

	$db["curso"] = $this->_html($db["curso"],"p","centralizado;maiusculo;negrito");

	$db["titulocompleto"] = $this->_html($db["titulocompleto"],"p","centralizado;maiusculo;negrito");

	$db["footer"] = $db["cidade"].", ".$db["data"].".";

	$db["cidade"] = $this->_html($db["cidade"],"p","centralizado;maiusculo;negrito");

	$db["footer"] = $this->_html($db["footer"],"p","centralizado;negrito");

	$tb = "<table border='0' style='width:100%;height:600px;border:0px;'>";
	
	// Header
	$tb .= "<tr><td height=\"100\" align=\"center\" valign=\"top\">";
	$tb .= $db["entidade"];
	$tb .= $db["curso"];
	$tb .= "</td></tr>";

	// Autores
	$tb .= "<tr><td height=\"296\" align=\"center\" valign=\"middle\">";
		$autor = explode(',',$db["autores"]);
		for($i=0;$i<count($autor);$i++) :
			$autor[$i] = $autor[$i]."<br>";
		endfor;
		$db["autores"] = $this->_html(implode($autor),"p","centralizado;maiusculo;negrito");

	$this->identificacao['autores'] = $db["autores"];

	$tb .= $db["autores"];
	$tb .= "</td></tr>";

	// Título principal
	$tb .= "<tr><td height=\"160\" align=\"center\" valign=\"middle\">";
	$tb .= $db["titulocompleto"];

	if($tituloadd != null):
		$tb.= $this->_html("<br>{$tituloadd}","h1","centralizado;maiusculo;negrito");
	endif;

	$tb .= "</td></tr>";

	// Footer
	$tb .= "<tr><td height=\"360\" align=\"center\" valign=\"bottom\">";
	$tb .= $db["cidade"];
		$data = $this->formataData($db["data"],false,0);
		$data = ($data !== "0000") ? $data : null;
	$tb .= $this->_html($data,"p","centralizado;maiusculo;negrito");
	$tb .= "</td></tr>";

	$tb .= "</table>";

	$this->capa = $tb;

	$this->WriteHTML($tb);

}


private function contracapa($s = true) {

	if($this->config['contracapa'] == false): return false; endif;

	$tb = "<table border='0' style='width:100%;height:600px;border:0px;'>";

	$tb .= "<tr><td height=\"290\" align=\"center\" valign=\"middle\">";
	$tb .= $this->identificacao['autores'];
	$tb .= "</td></tr>";

	$tb .= "<tr><td height=\"170\" align=\"center\" valign=\"bottom\">";
	$tb .= $this->_html($this->identificacao['titulocompleto'],'h1','centralizado;maiusculo;negrito');

	if($this->identificacao['subtitulo'] != "") $tb .= $this->_html($this->identificacao['subtitulo'],'h1');

	$tb .= "</td></tr>";

	$tb .= "<tr><td height=\"292\" align=\"justify\" valign=\"middle\" style=\"text-align:justify;padding-left:8cm;font-size:10pt;\">";
	$tb .= $this->identificacao['natureza'];
	$tb .= "</td></tr>";	

	$tb .= "<tr><td height=\"160\" align=\"center\" valign=\"bottom\" style=\"\">";

	$rodape = $this->identificacao['cidade'] . ", " . $this->formataData($this->identificacao["data"],false,0);

	$tb .= $this->_html($rodape,"div","negrito");
	$tb .= "</td></tr>";	


	$tb .= "</table>";


	$this->WriteHTML($tb);

}

private function resumo() {

	if($this->identificacao['resumo'] == "" || $this->config['resumo'] == false) return false;

	$titulo = $this->_html("Resumo","h1","centralizado;maiusculo;negrito");

	$this->WriteHTML( $titulo ."<br>" );
	$this->WriteHTML($this->identificacao['resumo']);

}

private function topicos() {

	// Verifica se tópicos existem
	if( $this->topicosVerifica(1) ) {
		$this->topicosLoop(1,null);	
	}

}
private function topicosSelect($n,$pai = null) {

	$q = "SELECT * FROM topico WHERE idprojeto='$this->projetoID' AND nivel=$n";
	if($pai !== null) {
		$q .= " AND idpai=$pai"; 
	}
	$q .= " ORDER BY ordem,id";

	return $this->mysql->query($q);
}

private function topicosVerifica($n,$pai=false) {
		
		if(!$pai) :
			$var = "idpai IS NULL";
		else:
			$var = "idpai=$pai";
		endif;

		$q = "SELECT id from topico WHERE idprojeto=$this->projetoID AND nivel=$n AND ".$var;
		return $this->mysql->existe($q);
}

private function topicosLoop($nivel,$idpai,$prefixo=false) {
	$prefixo .= (!$prefixo) ? "" : ".";
	$l = $this->topicosSelect($nivel,$idpai);

	foreach ($l as $linha) :
		$nivel = $linha["nivel"];
		$sub = $this->topicosVerifica( $linha["nivel"] + 1, $linha["id"]);
		$varprefixo = $prefixo.$linha["ordem"]." ";

		// Seta as notas de rodapé
		if($nivel == 1) {
			$this->AddPage('','','','','off');
			$titulo = $this->_html($varprefixo . $linha["titulo"],"h1","negrito;maiusculo");
			$this->sumarioIndex($varprefixo . $linha["titulo"],"negrito;maiusculo",$this->limpaVar($linha["titulo"]));
		}else if($nivel >= 3) {
			$titulo = $this->_html($varprefixo . $linha["titulo"],"h1",null);
			$this->sumarioIndex($varprefixo . $linha["titulo"],null,$this->limpaVar($linha["titulo"]));
		}else {
			$titulo = $this->_html($varprefixo . $linha["titulo"],"h1","negrito;");
			$this->sumarioIndex($varprefixo . $linha["titulo"],"negrito",$this->limpaVar($linha["titulo"]));
		}

		$this->WriteHTML( $titulo );
		// $this->WriteHTML($this->_br());
		$this->criaAncora($linha["titulo"]);
	
		$conteudo = $this->tratarHtml( $linha["html"]) ;

		$this->WriteHTML( $conteudo );

		$this->WriteHTML($this->_br());
		if( $sub ) :
			$this->topicosLoop($linha["nivel"] + 1, $linha["id"], $prefixo.$linha["ordem"] );
		endif;
	endforeach;
}
private function limpaVar($titulo) {
	return strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($titulo)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
}

private function sumarioIndex($titulo,$css,$anchor) {
	$vardots = $this->url."_mpdf/includes/dot.png";
	$page = $this->page + 1;

	$css = $this->_css($css);
	$this->qtd_sumario++;

	$tr = '<div style="margin-bottom:8px;display:block;">';
	$tr .= '<table class="sumario" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background:url('.$vardots.') repeat-x bottom center;">';
	$tr .= '<tr><td align="left">';
	$tr .= '<a href="#'.$anchor.'" style="'.$css.'background:#FFF;text-decoration:none;color:#000;display:block;border-right:3px solid #fff;float:left;">'.$titulo.'</a> </td><td nowrap="nowrap" align="right"><span style="background:#FFF;border-left:10px solid #fff;">'.$page.'</span></td></tr></table>';
	$tr .= '</div>';

	$v = $this->_html($tr,"div");
	$this->html_sumario .= $v;
}
private function sumario() {
	if($this->config['sumario'] == false) return false;

	$this->AddPage('','','','','on');

	$titulo = $this->_html("Sumário","p","centralizado;negrito;maiusculo");
	$this->WriteHTML($titulo);
	
	$this->WriteHTML($this->_br(1));
		$pg_in = $this->page;
	$this->WriteHTML($this->_html($this->html_sumario,"div","justificado"));
		$pg_off = $this->page;

	// Cpage 
	$cpage = 2;
	if($this->config['contracapa'] == true) $cpage=$cpage+1;
	if($this->config['resumo'] == true && $this->identificacao['resumo'] != "") $cpage=$cpage+1;

	$this->MovePages($cpage, $pg_in, $pg_off) ;
}

	private function referenciasWeb($a) {
		$e = "";
		if($a["nomeautor1"] !== null && $a["nomeautor1"] !== "") :
			$e .= $this->_html($a["sobrenomeautor1"],"span","maiusculo");
			$e .= ", ".$a["nomeautor1"];
			if($a["nomeautor2"] !== "" && $a["sobrenomeautor2"] !== "" && $a["maisautores"] == 0):
				$e .= "; ".$this->_html($a["sobrenomeautor2"],"span","maiusculo");
				$e .= ", ".$a["nomeautor2"];
			elseif($a["maisautores"] == 1) :
				$e .= $this->_html(" et al","em","italico");
			endif;
			$e .= ".&nbsp;";
		endif;
		$e .= $this->_html($a["titulo"],"b","negrito");

		$e .= ($a["url"]!=="") ? ". Disponível em: &lt;".$a["url"]."&gt;" : null;
		$e .= ($a["dataacesso"]!=="") ? " Acesso em: ".$this->formataData($a["dataacesso"])."." : null;

		$var["titulo"] = ($a["sobrenomeautor1"] == "") ? $a["titulo"] : $a["sobrenomeautor1"];
		$var["html"] = $this->_html($e,"div","esquerda;zeramargem");
		return $var;
	}
	private function referenciasLivro($a) {
		$e = "";
		if($a["nomeautor1"] !== "") :
			$e .= $this->_html($a["sobrenomeautor1"],"span","maiusculo");
			$e .= ", ".$a["nomeautor1"];
			if($a["nomeautor2"] !== "" && $a["sobrenomeautor2"] !== "" && $a["maisautores"] == 0):
				$e .= "; ".$this->_html($a["sobrenomeautor2"],"span","maiusculo");
				$e .= ", ".$a["nomeautor2"];
			elseif($a["maisautores"] == 1) :
				$e .= $this->_html(" et al","em","italico");
			endif;
			$e .= ".&nbsp;";

			// Titulo
			//$a["titulo"] = $this->preg_trim($a["titulo"]);
			//$this->preg_trim($a["titulo"]);
			$e .= $this->_html(trim($a["titulo"]),"b","negrito");
			$e .= ".&nbsp;";
			
		if($a["tipo"] == "livro") :
	  		$e .= ($a["edicao"] !== "") ? $a["edicao"].". ed. " : null; 
			$e .= ($a["local"] !== "") ? $a["local"]: null;
			$e .= ($a["local"] !== "" && ($a["editora"] !== "")) ? ": " : null;
			$e .= ($a["editora"] !== "") ? $a["editora"] : null;
			$e .= ", ".$this->formataData($a["datalancamento"],null,0).".";
			$e .= ($a["traducao"]!=="") ? " Traduzido por: ".$a["traducao"]."." : null;
		else: 
			$e .= ($a["local"] !== "") ? $a["local"] : null;
			$e .= ($a["datalancamento"]!== "") ? ", ".$this->formataData($a["datalancamento"])."." : null ; 
			$e .= ($a["edicao"] !== "") ? " v. ".$a["edicao"].", " : null; 
			$e .= ($a["pagina"]!=="") ? " p. ".$a["paginalivro"].". "  : null;
			$e .= ($a["caderno"]!=="") ? "".$a["artigocaderno"]."."  : null;
		endif;

		endif;

		$var["titulo"] = $a["sobrenomeautor1"];
		$var["html"] = $this->_html($e,"div","esquerda;zeramargem");
		return $var;
	}
	private function referenciasOutro($a) {
		$e = "";
		if($a["html"] !== ""):
			$e .= str_replace("<p>","<p style='text-align:left;'>",$a["html"]);
		endif;

		$var["titulo"] = strip_tags($a["html"]);
		$var["html"] = $this->_html($e,"div","esquerda;zeramargem");

		return $var;
	}

private function referencias() {
	$q = "SELECT * FROM referencia WHERE idprojeto = $this->projetoID";
	$query = $this->mysql->query($q);

	if($query == false) return false;

	$conteudo = array();
	$x=0;

		foreach($query as $a) :
		$tipo = $a["tipo"];
			switch($tipo):
				case "web":
					$conteudo[$x] = $this->referenciasWeb($a);
				break;
				case "livro":
					$conteudo[$x] = $this->referenciasLivro($a);
				break;
				case "artigo":
					$conteudo[$x] = $this->referenciasLivro($a);
				break;
				case "outro":
					$conteudo[$x] = $this->referenciasOutro($a);
				break;
			endswitch;
			$x++;
		endforeach;
	

	$t = "Referências";
	$this->AddPage('','','','','off');
	
	$this->sumarioIndex($t,"negrito;maiusculo",$this->limpaVar($t));
	$this->criaAncora($t);
	$titulo = $this->_html($t,"h1","centralizado;negrito;maiusculo");

	$this->WriteHTML($titulo);
	$this->WriteHTML($this->_br());

	// Ordenação alfabética
	function compareByName($a, $b) {
	  return strcmp($a["titulo"], $b["titulo"]);
	}
	usort($conteudo, 'compareByName');

	for($i=0;$i < count($conteudo) ; $i ++) :
		$this->WriteHTML($conteudo[$i]["html"].$this->_br());
	endfor;

}

private function tituloIsolado($titulo) {
	$var = "<table border='0' width='100%'><tr><td valign='middle' align='center' style='height:920px;'>";
	$var .= $this->_html($titulo,"p","negrito;maiusculo;centralizado");
	$var .= "</td></tr></table>";
	return $var;
}

private function anexos() {

	if($this->config['anexos'] == false) return false;

	$q = "SELECT * FROM anexo WHERE idprojeto = $this->projetoID AND tipo='anexo' ORDER BY ordem";
	$query["anexo"] = ($this->mysql->existe($q)) ? $this->mysql->query($q) : false;

	$q = "SELECT * FROM anexo WHERE idprojeto = $this->projetoID AND tipo='apendice' ORDER BY ordem";
	$query["apendice"] = ($this->mysql->existe($q)) ? $this->mysql->query($q) : false;
	

if($query["apendice"] !== false):
	$this->AddPage('','','','','off');
	$this->sumarioIndex("Apêndice","negrito;maiusculo","apendices");
	$this->criaAncora("apendices");
	$t = $this->tituloIsolado("Apêndice");
	$this->WriteHTML($t);

	$c = 0;
	foreach($query["apendice"] as $linha):
		$this->AddPage('','','','','off');
		$linha["titulo"] = ($linha["titulo"] != "") ? $this->_html("APÊNDICE ".$this->alfabeto[$c]." - ".$linha["titulo"],"p","negrito;centralizado;maiusculo") : null;
		
		$this->sumarioIndex($linha["titulo"],"negrito;maiusculo","apendice".$c);
		
		$this->WriteHTML($linha["titulo"]);
		$this->criaAncora("apendice".$c);
		$this->WriteHTML($this->_br());
		$this->WriteHTML($this->tratarHtml($linha["html"]));
	$c++;
	endforeach;

endif;

if($query["anexo"] !== false):
	$this->AddPage('','','','','off');
	$this->sumarioIndex("Anexos","negrito;maiusculo","anexos");
	$this->criaAncora("anexos");
	$t = $this->tituloIsolado("Anexos");
	$this->WriteHTML($t);

	$c = 0;
	foreach($query["anexo"] as $linha):
		$this->AddPage('','','','','off');
		$linha["titulo"] = ($linha["titulo"] != "") ? $this->_html("ANEXO ".$this->alfabeto[$c]." - ".$linha["titulo"],"p","negrito;centralizado;maiusculo") : null;
		
		$this->sumarioIndex($linha["titulo"],"negrito;maiusculo","anexo".$c);

		$this->WriteHTML($linha["titulo"]);
		$this->criaAncora("anexo".$c);
		$this->WriteHTML($this->_br());
		$this->WriteHTML($this->tratarHtml($linha["html"]));
	$c++;
	endforeach;

endif;

}


private function criaAncora($titulo) {
	$this->WriteHTML("<a name='".$this->limpaVar($titulo)."'></a>");
}

public function __criar() {

	if($this->projetoID == null) return false;

	$this->setMysql();
	$this->allow_charset_conversion=true;
	$this->charset_in='UTF-8';

	// Exibe as informações
	if($this->config['numeracao'] == true) $this->setHTMLHeader('<p style="text-align:right;font-size:11pt;">{PAGENO}</p>');
	
	$q = "SELECT * FROM projeto WHERE id=$this->projetoID";
	$this->identificacao = $this->mysql->listar($q);

	$this->capa();

	$this->contracapa();	

	$this->resumo();
	
	$this->topicos();

	$this->referencias();

	$this->anexos();

	$this->sumario();

	 // Gera saída do arquivo

	 /* I ou D */
	$this->Output("nome",$this->config['visualizar']);
}

}

?>