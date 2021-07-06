<?php
ob_start();
session_start();
if (!isset($_SESSION['loginUser']) && (!isset($_SESSION['senhaUser']))) {
  header("Location: ../index.php?acao=negado");
  exit;
}
include_once('sair.php');
?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Traz Pra Mim</title>
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="../dist/css/estilo.css">
</head>

<body class="hold-transition ">
  <div class="wrapper">
    <?php

    include_once('../config/conexao.php');
    $usuarioLogado = $_SESSION['loginUser'];
    $senhaDoUsuario = base64_encode($_SESSION['senhaUser']);
    $selectUser = "SELECT * FROM tb_user WHERE email_user=:emailUserLogado AND senha_user=:senhaUserLogado";

    try {

      $resultadoUser = $conect->prepare($selectUser);
      $resultadoUser->bindParam(':emailUserLogado', $usuarioLogado, PDO::PARAM_STR);
      $resultadoUser->bindParam(':senhaUserLogado', $senhaDoUsuario, PDO::PARAM_STR);
      $resultadoUser->execute();

      $contar = $resultadoUser->rowCount();
      if ($contar > 0) {
        while ($show = $resultadoUser->FETCH(PDO::FETCH_OBJ)) {

          $id_user = $show->id_user;
          $foto_user = $show->foto_user;
          $nome_user = $show->nome_user;
          $email_user = $show->email_user;
          $senha_user = $show->senha_user;
        }
      } else {
        echo '<div class="alert alert-danger"> <strong>Aviso!</strong> Não há dados com de perfil :(</div>';
      }
    } catch (PDOException $e) {
      echo "ERRO DE LOGIN DO PDO : " . $e->getMessage();
    }
    ?>
    <nav class="navbar navbar-expand navbar-white navbar-light" style="background-color: #F26868;">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="home.php?acao=bemvindo" class="nav-link">
            <p>
              Viagens
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="home.php?acao=inicio" class="nav-link">
            <p>
              Todas Viagens
            </p>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" title="Perfil e Saída">
            <i class="fas fa-user-circle"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="home.php?acao=perfil" class="dropdown-item">
              <i class="fas fa-user-alt mr-2"></i></i> Editar Perfil
            </a>
            <div class="dropdown-divider"></div>
            <a href="?sair" class="dropdown-item">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </li>
    </nav>