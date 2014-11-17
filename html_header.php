<body id="<?php echo Fluxo::bodyId(); ?>" class="<?php echo Fluxo::bodyClass(); ?>">

<div id="full">
<aside id="sidebar-nav" class="sidebar-wrapper">
  <header class="brand">
    <div id="logo-main">
    <h1 class="logo">
      <a href="#" role="button" title="Clipwork - Logado no sistema">
        <figure class="brander">
        <img class="large" src="img/logo-large.png"/>
        <img class="small" src="img/logo-small.png" aria-hidden="true"/>
        </figure>
      </a>
    </h1>
  </div>
  </header>

  <nav class="main-menu-nav" aria-label="Menu 1 - Minha conta">
    <ul role="menu">
        <li role="menuitem">
          <a href="linha.php" class="box" data-toggle="tooltip" data-placement="right" title="Resumo">
            <i class="fa fa-rss"></i>
            <span>Resumo</span>
          </a> 
        </li>
        <li role="menuitem">
          <a href="linha.php?pg=novo" class="novo-trabalho" data-toggle="tooltip" data-placement="right" title="Novo trabalho">
            <i class="fa fa-plus-square"></i>
            <span>Novo Trabalho</span>
          </a>
        </li>
        <li role="menuitem">
          <a href="linha.php?pg=listar" class="meus-trabalhos" data-toggle="tooltip" data-placement="right" title="Meus trabalhos">
            <i class="fa fa-bars"></i>
            <span>Meus trabalhos</span>
          </a>
        </li>
        <li role="menuitem">
          <a href="linha.php?pg=acompanhando" class="acompanhando" data-toggle="tooltip" data-placement="right" title="Acompanhando">
            <i class="fa fa-bookmark"></i>
            <span>Acompanhe
              
              <?php
              $countAcomp = Usuario::news("acompanhe");
                 // Mostra contagem de trabalhos pendentes
                if($countAcomp > 0):
                  echo "<span class='pring' role='presentation' id='countAcompanhe'>".$countAcomp."<span class='sr-only'> trabalho aguardando sua aprovação</span></span>";
                endif;
              ?>

            </span>
          </a>
        </li>
        <li role="menuitem">
          <a href="linha.php" class="ajuda" data-toggle="tooltip" data-placement="right" title="Ajuda">
          <i class="fa fa-question-circle"></i>
            <span>Ajuda</span>
            </a>
        </li>
    </ul>  
  </nav>

</aside>


<section class="content-wrapper">
<nav class="container-fluid breadcrumb-nav">
  <div class="col-xs-8 visible-md visible-lg">
    <a href="linha.php" aria-label='Voltar para a página anterior' onclick="window.history.go(-1); return false;"> 
      <span class="fa fa-arrow-left"></span>
      Voltar </a>
    <?php //echo PageInfo::breadcrumb(); ?>
  </div>

  <div class="top-nav col-xs-12 col-md-4 text-center">
      <ul role="menu">
        <li class="user-name" aria-label="Informação">
          <span class="sr-only">Usuário logado: </span>
          <i class="fa fa-user"></i>
          <span class="user"><?php echo Secao::get("nome_sobrenome"); ?></span>
        </li>
        <li class="dropdown">
          <a href="#" data-toggle="dropdown" aria-label='Expandir menu configurações de usuário' class="dropdown-button">
            <span class="fa fa-cog"></span>
            <span class="hide">Configurações do usuário</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dLabel">
              <li class="profile-edit">
                <a href="linha.php?pg=perfil" data-toggle="tooltip" title="Editar perfil" data-placement="left">Perfil</a>
              </li>
              <li class="hide">
                <a href="javascript:void(0)" id="reduzir-tela" data-toggle="tooltip" title="Alternar modo" data-placement="left">Alternar modo</a>
              </li>
              <li class="exit">
                <a href="logout.php" data-toggle="tooltip" title="Logoff" data-placement="left" aria-label="Logoff"> 
                  <i class="fa fa-close" aria-hidden="true"></i>
                <strong> Sair </strong> </a>
              </li>
          </ul>
        </li>
      </ul>
  </div>
</nav>