<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Cadastro de Viagem</h1>
        </div>

      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-primary">
            <div class="card-header" style="background-color: #F26868;">
              <h2 class="card-title">Cadastrar Viagem</h2>
            </div>

            <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="card-body">
                <div class="form-group">
                  <label>Nome do Produto</label>
                  <input type="text" class="form-control" name="nome" id="nome">
                </div>
                <div class="form-group">
                  <label>Destino</label>
                  <input type="text" class="form-control" name="destino" id="destino">
                </div>
                <div class="form-group">
                  <label>Origem</label>
                  <input type="text" class="form-control" name="origem" id="origem">
                </div>

                <div class="form-group">
                  <label>Descrição</label>
                  <input type="text" class="form-control" name="descricao" id="descricao">
                </div>

                <div class="form-group">
                  <label>Preço</label>
                  <input type="text" class="form-control" name="preco" id="preco" required placeholder="00,00">
                </div>

                <div class="form-group">
                  <label>Foto do Produto</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="foto" id="foto" required>
                      <label class="custom-file-label">Arquivo de imagem</label>
                    </div>

                  </div>
                </div>

              </div>
              <div class="card-footer">
                <button type="submit" name="botao" class="btn btn-primary" style="background-color: #F26868;">Finalizar Cadastro</button>
              </div>
            </form>
            <?php
            include('../config/conexao.php');
            if (isset($_POST['botao'])) {
              $nome = $_POST['nome'];
              $destino = $_POST['destino'];
              $origem = $_POST['origem'];
              $descricao = $_POST['descricao'];
              $preco = $_POST['preco'];
              $formatP = array("png", "jpg", "jpeg", "JPG", "gif");
              $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

              if (in_array($extensao, $formatP)) {
                $pasta = "../img/";
                $temporario = $_FILES['foto']['tmp_name'];
                $fotoconvert = uniqid() . ".$extensao";

                if (move_uploaded_file($temporario, $pasta . $fotoconvert)) {
                  $cadastro = "INSERT INTO viagem (nome,destino,origem,descricao,preco,foto) VALUES (:nome,:destino,:origem,:descricao,:preco,:foto)";
                  try {

                    $result = $conect->prepare($cadastro);
                    $result->bindParam(':nome', $nome, PDO::PARAM_STR);
                    $result->bindParam(':destino', $destino, PDO::PARAM_STR);
                    $result->bindParam(':origem', $origem, PDO::PARAM_STR);
                    $result->bindParam(':descricao', $descricao, PDO::PARAM_STR);
                    $result->bindParam(':preco', $preco, PDO::PARAM_STR);
                    $result->bindParam(':foto', $fotoconvert, PDO::PARAM_STR);
                    $result->execute();
                    $contar = $result->rowCount();

                    if ($contar > 0) {
                      echo '<div class="container">
                                    <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-check"></i> OK!</h5>
                                    Dados inseridos com sucesso !!!
                                  </div>
                                </div>';
                      header("Refresh: 5, home.php");
                    } else {
                      echo '<div class="container">
                                      <div class="alert alert-danger alert-dismissible">
                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                      <h5><i class="icon fas fa-check"></i> Erro!</h5>
                                      Dados não inseridos !!!
                                    </div>
                                  </div>';
                      header("Refresh: 5, home.php");
                    }
                  } catch (PDOException $e) {
                    echo "<strong>ERRO DE PDO= </strong>" . $e->getMessage();
                  }
                } else {
                  echo "Erro, não foi possível fazer o upload do arquivo!";
                }
              } else {
                echo "Formato Inválido";
              }
            }
            ?>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Suas Viagens</h3>
            </div>
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nome</th>
                    <th>Destino</th>
                    <th>Preço</th>
                    <th style="width: 40px">Editar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $select = "SELECT id, nome, destino, origem, descricao, preco, foto FROM viagem ORDER BY id DESC LIMIT 6";
                  try {
                    $result = $conect->prepare($select);
                    $cont = 1;
                    $result->execute();

                    $contar = $result->rowCount();
                    if ($contar > 0) {
                      while ($show = $result->FETCH(PDO::FETCH_OBJ)) {
                  ?>

                        <tr>
                          <td><?php echo $cont++; ?></td>
                          <td><?php echo $show->nome; ?></td>
                          <td>
                            <?php echo $show->destino; ?>
                          </td>
                          <td>
                            <?php echo $show->preco; ?>
                          </td>
                          <td>
                            <div class="btn-group">
                              <a href="home.php?acao=editar&id=<?php echo $show->id; ?>" class="btn btn-success" title="Editar a Viagem"><i class="fas fa-user-edit"></i></button>
                                <a href="conteudo/delete.php?idDel=<?php echo $show->id; ?>" onclick="return confirm('Deseja remover a Viagem')" class="btn btn-danger" title="Apagar Viagem"><i class="fas fa-user-times"></i></a>
                            </div>
                          </td>
                        </tr>
                  <?php
                      }
                    } else {
                    }
                  } catch (PDOException $e) {
                    echo '<strong>ERRO DE PDO= </strong>' . $e->getMessage();
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</section>
</div>