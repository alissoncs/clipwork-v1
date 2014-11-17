<?php
	//echo ID_PROJETO;

		// $pdf = new Compilar;
		// $pdf->setProjetoID($_POST["idprojeto"]);
		// //echo ID_PROJETO;
		// // if(isset($_POST)) : $pdf->setConfiguracoes($_POST); endif;
		// $pdf->setPDF(true);
		// $pdf->__criar();
	//exit();
?>
<div class="clearfix hs"></div>

<div class="pdf-export col-xs-12 col-lg-10" data-export="pdf" id="exportar-pdf">

<div class="row">

	<div class="col-xs-12 col-md-6">
		<form id="exportar-trabalho" method="post" action="_acoes/gerarpdf.php?f=gerarPdfTrabalho" class="experience-box" target="_blank">
			<legend class="title h2">Exportar trabalho</legend>

			<input type="hidden" value="<?php echo ID_PROJETO; ?>" name="idprojeto"/>
			
			<div class="form-content">

				<label for="sumario" aria-label="Habilitar sumário">
					<input type="checkbox" name="sumario" checked/>
					Sumário
				</label>

				<label for="numeracao" aria-label="Habilitar númeração de páginas">
					<input type="checkbox" name="numeracao" checked/>
					Numeração de página
				</label>
				<hr>
				<label for="contracapa" arial-label="Habilitar contra-capa">
					<input type="checkbox" name="contracapa" checked/>
					Folha de rosto
				</label>

				<label for="resumo" arial-label="Habilitar resumo">
					<input type="checkbox" name="resumo" title="Habilitar resumo"
					<?php if($info['resumo']==null) echo "disabled"; ?>
					/>
					Resumo <?php if($info['resumo']==null) echo "<em class='red-info'>Resumo vazio</em>"; ?>
				</label>

				<label for="sumario" aria-label="Habilitar anexos e apêndices">
					<input type="checkbox" name="anexos"
					<?php if($info['anexo']==0) echo "disabled"; ?>
					<?php if($info['anexo']>0) echo "checked"; ?>
					/>
					Anexos e apêndices <?php if($info['anexo']==0) echo "<em class='red-info'>Nenhum anexo/apêndice</em>"; ?>
				</label>

				<!-- <label for="adicionais" arial-label="Habilitar páginas adicionais">
					<input type="checkbox" name="adicionais"/>
					Páginas adicionais
				</label> -->

			</div>

			<div class="form-submit row text-right">
				<div class="btn-group">
					<button type="submit" title="Fazer download do arquivo PDF" name="download" aria-label="Fazer download do arquivo PDF" class="btn">
						Download
					</button>

					<button type="submit" title="Visualizar pelo navegador" aria-label="Visualizar pelo navegador" name="visualizar" class="btn btn-default">
						Visualizar
					</button>
				</div> <!-- btn-group -->
			</div>

		</form>
	</div> 

	<div class="hs visible-sm visible-xs"></div>

	<div class="col-xs-12 col-md-6">

		<form id="exportar-trabalho" method="post" action="_acoes/gerarpdf.php?f=gerarPdfNotas" class="experience-box" target="_blank">
			<legend class="title h2">Exportar anotações</legend>

			<input type="hidden" value="<?php echo ID_PROJETO; ?>" name="idprojeto"/>

			<div class="form-content">

				<fieldset>
					<label for="capa" aria-label="Habilitar capa">
						<input type="checkbox" name="capa" checked/>
						Capa
					</label>

					<label for="inativas" aria-label="Habilitar notas inativas">
						<input type="checkbox" name="inativas" checked/>
						Mostrar notas inativas
					</label>

					<label for="separar" aria-label="Separar notas ativas de notas inativas">
						<input type="checkbox" name="separar"/>
						Separar notas ativas de inativas
					</label>
				</fieldset>
			<?php 
				if($info['nota'] == 0) echo "<em class='red-info row'>Nenhuma nota cadastrada</em>";
			?>
			</div>

			<div class="form-submit row text-right">
				<div class="btn-group">
					<button type="submit" 
					title="Fazer download do arquivo PDF" 
					name="download" aria-label="Fazer download do arquivo PDF" class="btn"
					<?php if($info['nota'] == 0) echo "disabled"; ?>>
						Download
					</button>

					<button type="submit" 
					title="Visualizar pelo navegador" 
					aria-label="Visualizar pelo navegador" name="visualizar" class="btn btn-default"
					<?php if($info['nota'] == 0) echo "disabled"; ?>>
						Visualizar
					</button>
				</div> <!-- btn-group -->
			</div>

		</form>

	</div> 
</div> <!-- row -->

</div>
