$(function(){
window.$alertModal = $("#alert-modal");
window.$alertModalTitle = $("#alert-modal").find("h4");
window.$alertModalText = $("#alert-modal").find(".modal-body");

window.alertModal = function(t,c) {
	if(typeof t === "string" && typeof c === "string") {
		$alertModalTitle.html(t);		
		$alertModalText.html(c);		
	}
	$alertModal.modal("show").on('hide.bs.modal', function() {
		$(".modal-backdrop").first().remove();
	 	$alertModalTitle.html("");		
		$alertModalText.html("");
	}).focus();
}

var get_URL_VAR = function(name) {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
    function(m,key,value) {
      vars[key] = value;
    });
    return vars[name];
}

// Funções AJAX
var ajax = {
	form: function(url,serialize,callback,alert) {

		if($("#idprojeto").length && idprojeto.value == get_URL_VAR("id")) {
	    	if(!serialize) {
	    		serialize = "idprojeto="+idprojeto.value;
	    	}else {
	    		serialize = serialize+"&idprojeto="+idprojeto.value;
	    	}
	    }
		
		$.ajax({
		    type: "POST",
		    url: "_acoes/"+url,
		    data: serialize,
		    async:false,
		    cache:false,
		    success: function(data) {
		    	console.log("Requisição FORM com sucesso");
		    	if(typeof(callback) === "function") {
		    		callback();
		    		console.log("After Callback");
		    	}
		    	if(alert != false) {
		    		alertModal("Notificação",data);
		    		console.log("After Callback");
		    	}
		    },
		    error: function() {
		    	console.log("Requisição FORM ocorreu erro");
		    	alertModal("Erro","Ocorreu um erro. Tente novamente!");	
		    }
  		});
	},
    html: function(url,$retorno,callback,serialize) {
    	$elem = (typeof $retorno === "string") ? $($retorno) : $retorno;

    	if($("#idprojeto").length && idprojeto.value == get_URL_VAR("id")) {
	    	if(!serialize) {
	    		serialize = "idprojeto="+idprojeto.value;
	    	}else {
	    		serialize = serialize+"&idprojeto="+idprojeto.value;
	    	}
	    }

    	$.ajax({
		    type: "POST",
		    url: "_acoes/"+url,
		    cache: false,
		    data: serialize,
		    async:false,
		    success: function(data) {
		    	console.log("Requisição HTML com sucesso");
		    	if($elem.length) {
		    		$elem.html(data);
		    	}else {
		    		console.log("Conteudo nao encontrado");
		    	}
		    	if(callback && typeof(callback) == "function") {
		    		callback();
		    	}
		    },
		    beforeSend: function(){
		    },
		    error: function() {
		    	alertModal("Erro","Ocorreu um erro. Tente novamente!");	
		    }
  		});
    },
    json: function(url,serialize,callback) {
    	
    	if($("#idprojeto").length && idprojeto.value == get_URL_VAR("id")) {
	    	if(!serialize) {
	    		serialize = "idprojeto="+idprojeto.value;
	    	}else {
	    		serialize = serialize+"&idprojeto="+idprojeto.value;
	    	}
	    }

		$.ajax({
		    type: "POST",
		    url: "_acoes/"+url,
		    dataType: 'json',
		    cache: false,
    		async: false,
    		data: serialize,
		    success: function(pomp) {
				if(callback && typeof(callback) == "function") {
		    		callback(pomp);
		    	}
		    },
		    beforeSend: function(){
		    	console.log("Carregando...");
		    },
		    error: function(b,x) {
		    	alertModal("Erro desconhecido! Notifique-nos");
		    }
  		});
    }
}

// Eventos AJAX
$(document).on("submit","form[rel='ajax']",function(event){
	event.preventDefault();

	var $elem = $(this);
	var fn = $(this).data("fn").split(";");
	var $modal = $(this).closest(".modal")

	var $spinner = $(this).find(".spinner");
	$spinner.addClass("show");

		ajax.form( fn[0]+".php?f="+fn[1] , $elem.serialize(),function(){
			setTrigger(fn[0],fn[1]);
		});

		$modal.modal("hide");
		$spinner.removeClass("show");

	if(!$elem.hasClass("no-clear")) {
		$elem.limparCampos();
	}
 
	return false;
});
// Click AJAX trigger
$(document).on("click","[data-type=ajax]",function(){
	var fn = $(this).data("fn").split(";");	

	var retorno = ($(this).data("alert") || $(this).data("alert") == "true");

	ajax.form( fn[0]+".php?f="+fn[1],$(this).data("post"),function(){
	    setTrigger(fn[0],fn[1]);
	},retorno);
	return false;
});

if(currentPage == "pg-novo" || currentPage == "pg-config") {

	var $campo = $('form').find("#set-people");
	var $campo_input = $campo.find("input");
	var $response = $('form').find('#seted-people');

// Chama ajax de incluir pessoas
$campo.on("click",".submit", function(){
	if( $campo_input.val() !== "" ) {
		exist = $("#seted-people").find("[data-email='"+$campo_input.val()+"']").length > 0;
		if(exist) {
			alertModal("Aviso","Este e-mail já foi adicionado");
		}else {
		$.ajax({
			type: "POST",
			//dataType : "json",
			data: "email="+$campo_input.val(),
			url: "_acoes/projeto.php?f=incluirUsuario",
			success: function(json){
					
				if(json.indexOf("span") == -1) {
					alert(json);
				}else{
					$response.append(json)
						// Remove o span
					$response.find('.remove').on("click", function(e) {
						$elem = $(this).parent()
						$elem.fadeOut("fast",function(){
							$elem.remove()
						})
						return false;
					});
				}
			}
		 }); // ajax
		 }	
		 $campo_input.val("");
	}else {
		$campo_input.focus();
	}
	return false;
});


// Bloquea o enter no form
 $(document).on("keypress", 'form', function (e) {
     var code = e.keyCode || e.which;
     if (code == 13 && $("#input-new-user").is(":focus")) {
         e.preventDefault();
         $campo.find(".submit").click();
         return false;
     }
 });

} // pg-novo


var area = {
	notas:"#notas",
	topico:"#topico",
	referencia:"#referencia",
	editor:"#context-editor"
}

// Text editor
var $editor = $("#paper");
var $areaeditor = $(area.editor);

function summernoteSimples(classe,parent) {
	m = (classe) ? classe : ".summernote";
	p = (parent) ? parent : "body";
	$(m,p).tinymce({
             style_formats: [
                    {title: 'Paragrafo', block: 'p'},
                    {title: 'Nota de rodapé', inline: 'span', classes: 'rodape_nota', styles: {color: '#333'}}
            ],
            toolbar1: "bold italic underline removeformat | subscript superscript forecolor",
           
            menubar: false,
            toolbar_items_size: 'small',
            language : 'pt_BR',
            autosave_ask_before_unload: false
    });
}
summernoteSimples();

function setTrigger(x1,x2) {
	$.event.trigger({
	    type: x1,
	    acao: x2
	});
}
// -----------------------------------
// Exclusividades
// -----------------------------------
if(currentPage == "pg-topicos") {

var editor = {
	change: 0,
	tipo: "",
	id:"",
	controller:"#topico",
	ativo:false,
	btnsave: "#salva-texto",
	autosalvar: ($editor.data("autosave") == 1) ? true : false, 

	 init: function($elem) {
	 	if(!editor.id) {
	 	$areaeditor.focus();
	 	$areaeditor.addClass("active");
	$editor.addClass("active").tinymce({
            theme: "modern",
            plugins: [
              "advlist autolink lists link image table save visualchars textcolor colorpicker autosave",
            ],
             style_formats: [
                    {title: 'Paragrafo', block: 'p'}
            ],
            toolbar1: "undo redo styleselect removeformat | bold italic underline removeformat | subscript superscript forecolor | alignleft aligncenter alignright alignjustify blockquote | bullist numlist | unlink image table",

            menubar: false,
            toolbar_items_size: 'small',
            language : 'pt_BR',
            autosave_ask_before_unload: true,
             setup :function(ed) {
            	ed.on('init', function(args) {
		             $("#mceu_34").bind("click",function(e){
		             	$("#upload-modal").modal("show");
					   	e.stopPropagation();
					   	return false;
					 });
		        });
		        ed.on('change', function(e) {
		        	if(editor.autosalvar) {
			        	editor.change += 10;
			        	editor.verificaChange();
		        	}
		        });
		        ed.on('keyup', function (e) {  
		        	if(editor.autosalvar) {
		            	editor.change += 1;
		            	editor.verificaChange();
		            }
		        });
		        ed.on('blur', function (e) {  
		            editor.salvar();
		        });
            }
    });

	 	}
	},
	verificaChange:function() {
		console.log(editor.change);
		if(editor.change >= 50) {
			editor.salvar();
			editor.change = 0;
		}else {
			$(editor.btnsave).removeClass("disabled");
		}
	},
	getHtml: function() {
  		// $("#edit").editable("setHTML", "<p>My custom paragraph. Content</p>", false); // SETA HTML
        var html = $editor.html();
		return encodeURIComponent(html);
	},
	setHtml: function(c) {
		var v = decodeURIComponent(c);
		// $editor.tinymce().setContent(c);
		$editor.html(v);
	},
	setTitulo: function(c) {
		$areaeditor.find(".title h2").html(c);
		$areaeditor.find(".title").find("input[type=text]").val(c);
		return this;
	},
	setData: function (d,h) {
		$("#data-update").html("Data: "+d+" - Hora: "+h);
		return this;
	},
	serialize:function(){
		return "id="+this.id+"&html="+this.getHtml();
	},
	salvar: function() {
		if(this.id) {
			editor.change = 0;
			$(editor.btnsave).addClass("disabled");	
			var json = ajax.json("topico.php?f=atualizarTopico",editor.serialize(),function(data){
				editor.setData(data.data,data.hora);
			});
		}
	},
	destruir: function() {
		editor.setHtml("");
		editor.change = 0;
		editor.id = false;
		editor.ativo = false;
		$areaeditor.find(".wrapper-editor").removeClass("full-screen");
		$areaeditor.removeClass("active");
		editor.setTitulo("Selecione");
	}
}
	$(area.editor).find(".ampliar").on("click",function(){
		$(area.editor).find(".wrapper-editor").toggleClass("full-screen");
	});
	$(editor.btnsave).on("click",function(e){
		editor.salvar();
	});

function initSortable(callback) {
	var $sort1 = $(area.topico).find("ul");
	$sort1.sortable({
		connectWith: $(this),
		handle: ".handle",
		placeholder: "ui-state-highlight",
		update : function () {
			var order = $(this).sortable('toArray', {
		        attribute : 'data-id', key :'data-ordem'
		    });
			ajax.form("topico.php?f=reordenarTopico","ordem="+order,function(){
				setTrigger("topico",null);
			});
	    }
	});
} // Final
initSortable();

	// Eventos HANDLER
$(document).on("topico",function(f){
	// Refresh nos tópicos
	$("#spinner-topicos").addClass("show");
	ajax.html("topico.php?f=listarTopico","#topico",function(){
		initSortable();
		if(editor.id && f.acao !== "excluirTopico") {
			$("#topico").find("[data-id="+editor.id+"]").addClass("active");
		}
	});

	if(f.acao == "excluirTopico") {
		$(".id-topico").each(function(){
			$(this).val("");
		});
		editor.destruir();
	}else if(f.acao == "retitularTopico"){
		t = $("#topicoid-"+editor.id).find(".topico-detalhes").data('titulo');
		$(".title h2","#context-editor").html(t);
	}

	$("#spinner-topicos").removeClass("show");
	
});
// Editor ações
$(area.topico).on("click","a",function(){
	editor.init();
	$selector = $(this).closest(".topico").children(".topico-detalhes");

	// html = $selector.html();
	titulo = $selector.data("titulo");
	data = $selector.data("data");
	hora = $selector.data("hora");
	var id = $selector.data("id");

	$(this).closest("li").addClass("active");
	if(editor.id && editor.id !== id) {
		$(area.topico).find("[data-id="+editor.id+"]").removeClass("active");
	}
	$(".id-topico").each(function(){
		$(this).val(id);
	});
	if(id) {
		editor.id = id;	
		editor.setTitulo(titulo);
		 ajax.json("topico.php?f=pegarHtml","id="+id,function(data){
		 	//alert(data.html);
		  	editor.setHtml(data.html);
		 	editor.setData(data.data,data.hora);
		 });
	}
	return false;
});


} // pg-topicos
else if(currentPage == "pg-referencias"){
	$(document).on("referencia",function(f){
		ajax.html("referencia.php?f=listarReferencia","#referencia");
		summernoteSimples(false,"#referencia");
	});
}// referencias
else if(currentPage == "pg-notas"){
	$(document).on("notas",function(f){
		ajax.html("notas.php?f=listarNotas","#notas",function(){
			$("[data-toggle=tooltip]","#notas").tooltip();
		});
	});

	$("#mudar-modo").on("change",function(e){
		$($(this).data("target")).toggleClass("grid table");
	});

} // notas
else if(currentPage == "pg-anexo"){
	var count = 0;
	$editor = $("#anexo-textarea");
	$editor.addClass("active").tinymce({
            theme: "modern",
            relative_urls:false,
            paste_data_images: true,
            plugins: [
              "advlist autolink lists link image table save visualchars textcolor colorpicker autosave",
            ],
             style_formats: [
                    {title: 'Paragrafo', block: 'p'},
                    {title: 'Nota de rodapé', inline: 'span', classes: 'rodape_nota', styles: {color: '#333'}}
            ],
            toolbar1: "undo redo styleselect removeformat | bold italic underline removeformat | subscript superscript forecolor | alignleft aligncenter alignright alignjustify blockquote | bullist numlist | unlink image table",
            paste_data_images: true,
            menubar: false,
            toolbar_items_size: 'small',
            language : 'pt_BR',
            autosave_ask_before_unload: false,
            setup :function(ed) {
            	ed.on('init', function(args) {
		             $("#mceu_34").bind("click",function(e){
		             	$("#upload-modal").modal("show");
					   	e.stopPropagation();
					   	return false;
					 });
		        });
		        ed.on('change', function(e) {
		        	count++;
		        	console.log(count);
		        });
		        ed.on('keyup', function (e) {  
		            count++;
		            console.log(count);
		        });
            }
    });
$("#imagem").on("click",function(){
	$editor.execCommand('mceInsertContent',false,"content");
});
} // anexo
else if(currentPage == "pg-comentarios") {

var $list = $(".messages","#app-list"),
    $content = $("#app-content"),
    $autorcomentario = $("#comment-author"),
    $loading = $(".spinner-content .spinner","#app"),
    $mensagem = $("#content-message");

$list.on("click","li a",function(e){

	$list.find("li").filter(".active").removeClass("active");
	id = $(this).parent().addClass("active").data("id");
	
	// Carrega comentário

	$content.stop().fadeOut(200,function(){
		$loading.addClass("show").attr("aria-hidden","false").parent().show();
	});

	setTimeout(function(){
		ajax.html("comentario.php?f=getComentario",$content,function(){
			$loading.removeClass("show").attr("aria-hidden","true").parent().hide();
			$content.stop().fadeIn();
		},"id="+id);
	}, 1000);
	
	return false;
});

$(document).on("comentario",function(f){
	// if(f.acao == "excluirComentario")
	$alertModal.on("hide.bs.modal",function(){
		window.location.reload(true);
	});
});


}// pg-comentarios
else if(currentPage == "pg-pdf") {

}else if(currentPage == "pg-acompanhando") {
	/*
		Página de acompanhamento
	*/
	$(document).on("projeto",function(f){
			
		$alertModal.on("hide.bs.modal",function(){
			window.location.reload(true);
		});

	})
}
	$("#send-file").on("submit",function(e){
		e.preventDefault();
		var file_data = $("#file-input").prop('files')[0];   
		var form_data = new FormData(this);           
		$form = $(this);       
		var url =  $(this).attr("action");     
		    $.ajax({
		            url: url,
		            //dataType: 'text',
		            cache: false,
		            contentType: false,
		            processData: false,
		            data: form_data,                         
		            type: 'post',
		            success: function(data){
		            	$form.closest(".modal").modal("hide");
		             if(data && data !== 0 && data !== "0") {
		             	$form.find(".spinner").removeClass("show");
		               	$editor.html($editor.html()+'<p style="text-align:center;"><img src="'+data+'"/></p>');
		             }else {
		             	alertModal("Erro","Ocorreu um erro durante o upload.");
		             }
		            },
		            beforeSend:function(){
		            	$form.find(".spinner").addClass("show");
		            }
		     });
		    return false;
	});

});	
