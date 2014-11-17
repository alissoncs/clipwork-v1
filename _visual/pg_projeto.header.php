<header class="row context-control">
	<div role="heading" class="context-title col-xs-12 col-md-4 row">

		<?php if( $GLOBALS['at'] == true ): ?>

			<div class="placement left">	
				<h2 class="project-title" aria-label="Título do trabalho">
					<?php echo $info['nome']; ?>
				</h2>
			</div>

		<?php else: ?>
			<div class="placement left">	
				<h2 class="project-title" aria-label="Título do trabalho">
					
					<a href="#info" id="infollow" data-rel="item"
					data-toggle="modal" data-target="" title="Acompanhando">
						<i class="fa fa-bookmark"></i>
						<span class="sr-only">
							Informações sobre <?php echo $info['usuarionome']; ?>
						</span>
					</a>

					<?php 
					echo $info['nome']; ?>
					<em><?php echo $info['usuarionome']; ?></em>
				</h2>
			</div>
		<?php endif; ?>

		<div class="placement right" role="presentation">
			<span class="easy easy-menu dropdown"
			aria-haspopup="true"
			aria-expanded="false"
			aria-label="Expandir configurações">
			  <a href="#" data-toggle="dropdown">
				<span class="sr-only">Editar</span>
				<i class="fa fa-cog" aria-hidden="true"></i>
		 	  </a>
				<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="Menu configurações">
					<li role="menulist">
						<a href="<?php echo $menuprojeto->getUrl("config"); ?>">
							Configurações
						</a>
					</li>
				</ul>
			</span>

			<?php
				/* Menu mobile */
				$menuprojeto->mobileNav();
			?>

		</div> <!-- placement right -->

	</div> <!-- context-title -->

	<div class="col-xs-12 col-md-8 visible-lg menu-context complement">

		<?php
			/*
				Mostra menu somente se o usuário tiver acesso total
			*/
		// if( $GLOBALS['at'] == true ):
		?>

		<nav id="project-navigation" class="nav-project tab-list" aria-label="Menu de navegação">
			<ul>
				<?php
					$menuprojeto->navegacao();
				?>
			</ul>
		</nav>

		<?php // endif; ?>

	</div>
</header><!--  basic-informations -->

<?php
	include "_visual/modal_upload.php";
	include "_visual/modal_notas.php";
?>
