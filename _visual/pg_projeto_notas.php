
<header>
	<div class="row master">
		<h1 class="pull-left">Notas</h1>
		
		<button class="btn blue" data-toggle="modal" data-target="#nova-nota">Nova nota</button>

		<span class="change-visual">
					<input type="checkbox" name="notas-modo" id="mudar-modo" data-target="#notas" title="Mudar o modo de visualização: Modo leitura">
					Alternar modo de visualização
		</span>
	</div>
</header>

<div id="notas" class="grid">
		<?php
			include "_acoes/notas.php";
			listarNotas(3);
		?>
		</div>
	<div class="row section-footer">
	</div>
<?php 
	include dirname(__FILE__)."/modal_notas.php";
?>