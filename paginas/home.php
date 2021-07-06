<?php
include_once('../includes/header.php');
if (isset($_GET['acao'])) {
  $acao = $_GET['acao'];
  if ($acao == 'bemvindo') {
    include_once('../paginas/conteudo/cadastro.php');
  } elseif ($acao == 'editar') {
    include_once('../paginas/conteudo/update.php');
  } elseif ($acao == 'perfil') {
    include_once('../paginas/conteudo/perfil.php');
  } elseif ($acao == 'inicio') {
    include_once('../paginas/conteudo/inicio.php');
  }
} else {
  include_once('../paginas/conteudo/cadastro.php');
}
include_once('../includes/footer.php');
