<?php 
define('BASE_PATH',realpath(dirname(__FILE__)),true);

include BASE_PATH."/util.class.php";
$index = true;
include BASE_PATH."/html_head.php";
?>

<div class="wrapper-all page-front">

<?php if(isset($_SESSION["nome"])) :?>
<div class="btn-group abs-user">
  <a href="linha.php" class="span">
    Painel
  </a>
  <span class="user-logged">
    <?php echo $_SESSION["nome"]; ?>
  </span>
</div>
<?php endif; ?>

<div class="container-fluid">
<div class="row">
<div class="col-xs-12 col-sm-6 pin-logo">
  <h1 class="large-logo" id="flat-logo" role="banner">
    <span class="sr-only">Clipwork</span>
    <figure class="brander">
      <img class="no-retina" src="img/flat-logo.png" aria-hidden="true"/>
      <img class="retina" src="img/flat-logo@2x.png" aria-hidden="true"/>
    </figure>
  </h1>

</div> <!-- pin-logo -->

<div class="col-xs-12 col-sm-6 pin-right">

<div class="row js-tab col-lg-8 col-xs-12" id="painel-user">
<div class="text">
    <h2>
      Clipwork é um sistema para desenvolvimento de trabalhos científicos
    </h2>
  </div>

<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#login" title="Já tenho uma conta" role="tab" data-toggle="tab">Logar</a></li>
  <li><a href="#cadastro" role="tab" title="Ainda não tenho conta" data-toggle="tab">Cadastrar</a></li>
</ul>

<div class="tab-content">
<div class="tab-pane fade in active" data-section="1" id="login">
  <form id="login" class="validate" method="post" action="_acoes/usuario.php?f=logar">
      <label for="email">
        E-mail:
        <input name="email" type="text" title="Digite o e-mail cadastrado" required/>
      </label>

      <label for="senha">
        Senha:
        <input name="senha" type="password" title="Digite a sua senha" required/>
      </label>
      
      <div class="submit-area">
        <div class="hide">
          <input type="hidden" value="<?php //echo getBrowser(); ?>" name="navegador">
          <input type="hidden" value="<?php //echo getOS(); ?>" name="os">
          <input type="hidden" value="<?php //echo getClientIP(); ?>" name="clientip">
        </div>
        <button type="submit" class="btn big green" title="Clique aqui para entrar no painel">
          Entrar
        </button>
      </div>
    </form>
</div>

  <div class="tab-pane fade" data-section="2" id="cadastro">
<form method="post" class="validate" action="_acoes/usuario.php?f=cadastrar">
  <fieldset>
    <legend>Preencha os campos abaixo para fazer um cadastro no sistema</legend>

    <div class="row coll">
      <label for="nome" class="col-xs-12 col-sm-6">
        Nome:
        <input id="nome" name="nome" type="text" title="Digite seu nome" required/>
      </label>

      <label for="sobrenome" class="col-xs-12 col-sm-6">
        Sobrenome:
        <input name="sobrenome" title="Digite seu sobrenome" type="text" required/>
      </label>
    </div>

      <label class="form-group has-feedback">
        E-mail:
        <div class="input-group">
            <div class="input-group-addon" aria-label="Digite seu e-mail">@</div>
            <input name="email" title="Digite seu e-mail" type="text" required/>
        </div>
      </label>

    <div class="row coll">
      <label for="senhacad" class="col-xs-12 col-sm-6">
        Senha:
            <input id="senha1" name="senhacad" type="password" title="Digite uma senha que será utilizada no login" required/>
      </label>

      <label for="repitasenha" class="col-xs-12 col-sm-6">
        Repita a senha:
        <input id="repsenha1" name="repitasenha" type="password" data-repeat="#senha1" title="Digite a senha novamente (para sua segurança)" required/>
      </label>
    </div>

      <div class="submit-area">
        <button type="submit" class="btn big" title="Realizar o cadastro">
          Cadastrar
        </button>
        
      </div>
    </fieldset>
  </form>
  </div>
</div><!-- tab-content -->

</div>

</div> <!-- pin-right -->

</div>

</div><!--  container-fluid  -->

<?php
include_once "html_footer.php";
?>