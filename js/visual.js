
// Função que limpa os campos do formulário
$.fn.extend({
  limparCampos:function(c) {
 		var campos = "input[type='text'], textarea";	  
 		if(c) {
 			campos += ", "+c;
 		}
	  if(this.is("form")) {
	  	if(!this.hasClass("no-clear")) {
	  		var elem = this;
	  	}else {
	  		var elem = false;
	  	}
	  }else {
	  	var elem = this.closest("form");
	  }
	  if(elem){
	  	elem.find(campos).each(function() {
	  		if( !$(this).hasClass("no-clear") ) {
				$(this).val("");
			}
	  	}).end();
	  	elem.find(".after-clear").each(function(){
	  		$(this).remove();
	  	}).end();
	  }
	  	return this;
  },
  submitForm:function(fn,limpar) {
  		$(document).on("submit",this,function(){
  			fn();
  			if(limpar) {}
  			$(this).limparCampos();
  			return false;
  		});
  },
  validate:function() {
  	$(this).on("submit",function(e){
  		$form = $(this);
  		
  		// Verifica itens iguais
  		if( $form.find("[data-repeat]").length > 0 ) {
  			$rep = $form.find("[data-repeat]");
  			$def = $($rep.data("repeat"));
  			if( $rep.val() != $def.val() ) {
  				var oldvalue = $rep.val();

  				$rep.focus().closest("label").addClass("error");

  				$rep.on("blur",function(){
  					$(this).closest("label").removeClass("error");
  				});
  				return false;
  			}
  		}
  	});

  }
});

$(document).ready(function(){
window.currentPage = $("body").attr("id");
if(Modernizr.svg) {
	$("img","#logo-main").each(function(e){
		$(this).attr("src",function(){
			return $(this).attr('src').replace('.png', '@svg.svg');
		});
	});
}

$("label").on('click', function(){
	var vf = $(this).attr("for");
	if(vf) {
		$(this).find("input[name='"+vf+"'],textarea[name='"+vf+"'],select[name='"+vf+"']").focus();
	}
});

// Formulário - #addreferencia
$("#pg-referencias").delegate("select.toggle-tipo","change",function(){
	$form = $(this).closest("form");
	$form.removeClass("tipo-web tipo-livro tipo-outro tipo-artigo").addClass( "tipo-"+$(this).val() );
});

// Função para limpar formulários 
$(".form-reset").bind("click",function(e){
	e.preventDefault();
	$(this).limparCampos();
	return false;
});

$(".nav-tabs a","#painel-user").on("click",function(e){
	e.preventDefault();
});


if(currentPage == "pg-comentarios") {
	if(!Modernizr.touch) {
		// $("#app").children("div").each(function(){
		// 	$(this).css("min-height",$(window).height());
		// });
	}

}

// Valida formulário
	$("form").validate();

	$("[data-toggle=tooltip]","#full").tooltip();


	$("#reduzir-tela").on("click",function(){
		$("body").toggleClass("reduced")
	})

});