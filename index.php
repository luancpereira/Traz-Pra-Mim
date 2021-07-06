<?php
ob_start();
session_start();
if (isset($_SESSION['loginUser']) && (isset($_SESSION['senhaUser']))) {
  header("Location: paginas/home.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Traz Pra Mim | Log in</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
  <div class="card">
    <div class="login-box">
      <div class="login-logo">
        <a><b>Traz Pra Mim</b> </a>
      </div>
      <p class="login-box-msg">Para acessar entre com E-mail e Senha</p>
      <div class="card-body login-card-body">
        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Digite seu E-mail...">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="senha" class="form-control" placeholder="Digite sua Senha...">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <div class="col-12" style="margin-bottom: 5px">
              <button type="submit" name="login" class="btn btn-primary btn-block" style="background-color: #F26868;">Login</button>
            </div>
          </div>
        </form>
        <?php
        include_once('config/conexao.php');
        if (isset($_GET['acao'])) {
          $acao = $_GET['acao'];
          if ($acao == 'negado') {
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Erro ao Acessar o sistema!</strong> Efetue o login ;(</div>';
            header("Refresh: 2, index.php");
          } else if ($acao == 'sair') {
            echo '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Logout Concluido!</strong> Esperamos que você volte ;(</div>';
            header("Refresh: 2, index.php");
          }
        }
        if (isset($_POST['login'])) {

          $login = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
          $senha = base64_encode(filter_input(INPUT_POST, 'senha', FILTER_DEFAULT));
          $select = "SELECT * FROM tb_user WHERE email_user=:emailLogin AND senha_user=:senhaLogin";

          try {

            $resultLogin = $conect->prepare($select);
            $resultLogin->bindParam(':emailLogin', $login, PDO::PARAM_STR);
            $resultLogin->bindParam(':senhaLogin', $senha, PDO::PARAM_STR);
            $resultLogin->execute();

            $verificar = $resultLogin->rowCount();
            if ($verificar > 0) {

              $login = $_POST['email'];
              $senha = $_POST['senha'];
              $_SESSION['loginUser'] = $login;
              $_SESSION['senhaUser'] = $senha;

              echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Logado com sucesso!</strong> Você será redirecionado para o Traz Pra Mim :)</div>';

              header("Refresh: 2, paginas/home.php?acao=bemvindo");
            } else {
              echo '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Erro!</strong> login ou senha incorretos, digite outro login ou 
                faça o cadastro se ainda não tiver :(</div>';
              header("Refresh: 2, index.php");
            }
          } catch (PDOException $e) {
            echo "ERRO DE LOGIN DO PDO : " . $e->getMessage();
          }
        }
        ?>
        <p style="text-align: center; padding-top: 25px">
          <a href="registro_user.php" class="text-center">Registre-se</a>
        </p>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

</body>

</html>