<?php
	/*
		Lista de trabalhos que você acompanha
	*/

	//Fluxo::classe("db");
	//Fluxo::classe("inclusoes");


?>


<div class="container-fluid padd all">

<header class="master row">
	<h1>Trabalhos que você acompanha
	</h1>
</header>

<div role="main" class="row">
	<div class="col-xs-12 col-md-6">

	<?php
		include CONTROL."projeto.php";
		listarNaoAceitos();

		listarAcompanhando();
	?>

	</div>
</div> <!-- row (content) -->


</div>

