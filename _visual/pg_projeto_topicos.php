<div class="col-md-5 col-xs-12 role-list">
<div id="topico">
	<?php
		include "_acoes/topico.php";
		listarTopico();
	?>
</div>

<div class="row role-footer">
	<button class="btn" type="button" data-toggle="modal" accesskey="n" data-target="[data-modal='novotopico']">Novo tópico</button>
	<span class="spinner small" id="spinner-topicos" arial-label="Carregando"></span>
</div>

<?php 
	include dirname(__FILE__)."/modal_novo_topico.php";
?>
<!-- Tópico -->
</div>


<div class="col-md-7 col-xs-12 clear-padd" id="context-editor">
	<div class="wrapper-editor content">
		<div class="inside-editor">
			
			<div class="toolbar-content row">
				<div class="col-xs-6 title">
					<h2 aria-label="Tópico selecionado: ">Selecione <span class='sr-only'>um trabalho</span></h2>
					<button class="btn btn-sm btn-default btn-clear" type="button" aria-label="Editar título do tópico" title="Editar título do tópico" data-toggle="modal" data-target="#renomear-topico">
						<i class="fa fa-pencil"></i>
						<span class="sr-only">Renomear</span>
					</button> <!-- renomear -->
					<?php 
						include dirname(__FILE__)."/modal_editar_titulo_topico.php";
						include dirname(__FILE__)."/modal_excluir_topico.php";
					?>
					
				</div>

				<div class="controllers col-xs-6">
					<div class="toolbar-editor btn-group btn-group-sm">
						<button id="salva-texto" class="update-text btn btn-default" title="Salvar">
							<span class="fa fa-check-square-o"></span>
							<span class="fa fa-square-o"></span>
							<span>Salvar</span>
						</button>
						
						<button class="delete-text btn btn-default" title="Excluir" data-toggle="modal" data-target="[data-modal=excluir-topico]">
							<span class="fa fa-times"></span>
							<span class="sr-only">Excluir</span>
						</button>
						
						<button class="ampliar btn btn-default" title="Modo ampliado">
							<span class="fa fa-arrows-alt"></span>
							<span class="sr-only">Ampliar</span>
						</button>
						<span id="data-update" class="hide"></span>
					</div> <!-- toolbar-editor -->
				</div>
				
			</div> <!-- toolbar-content -->

			<div class="editor-area">
				<textarea id="paper" data-autosave="<?php echo $info['autosalvar']; ?>"></textarea>
			</div>
			
		</div> <!-- inside-editor -->
	</div> <!-- splash-editor -->
</div> <!-- context-editor -->