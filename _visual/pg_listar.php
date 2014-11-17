<div class="container-fluid padd all">

	<header class="master row">
		<h1>Meus trabalhos</h1>
		<h3 class="sr-only">Nesta página você verá todos os trabalhos que tem cadastrado</h3>
	</header>

<div class="row">
	<div class="col-lg-8 col-xs-12 project-ul">
	<?php
		include(CONTROL."projeto.php");
		listarProjetos();
	?>
	</div>
</div>


</div>