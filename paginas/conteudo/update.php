  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Alterar Viagem</h1>
          </div>

        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <?php
        include('../config/conexao.php');
        if (!isset($_GET['id'])) {
          header("Location: home.php");
          exit;
        }
        $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

        $select = "SELECT * FROM viagem WHERE id=:id";
        try {

          $resultado = $conect->prepare($select);
          $resultado->bindParam(':id', $id, PDO::PARAM_INT);
          $resultado->execute();

          $contar = $resultado->rowCount();
          if ($contar > 0) {
            while ($show = $resultado->FETCH(PDO::FETCH_OBJ)) {

              $idCont = $show->id;
              $nome = $show->nome;
              $destino = $show->destino;
              $origem = $show->origem;
              $descricao = $show->descricao;
              $preco = $show->preco;
              $foto = $show->foto;
            }
          } else {
            echo '<div class="alert alert-danger">Não há dados com o id informado!</div>';
          }
        } catch (PDOException $e) {
          echo "<strong>ERRO DE SELECT NO PDO: </strong>" . $e->getMessage();
        }
        ?>
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Alterar Viagem</h3>
              </div>
              <form role="form" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label>Nome do Produto</label>
                    <input type="text" class="form-control" name="nome" id="nome" required value="<?php echo $nome; ?>">
                  </div>
                  <div class="form-group">
                    <label>Destino</label>
                    <input type="text" class="form-control" name="destino" id="destino" required value="<?php echo $destino; ?>">
                  </div>
                  <div class="form-group">
                    <label>Origem</label>
                    <input type="text" class="form-control" name="origem" id="origem" required value="<?php echo $origem; ?>">
                  </div>
                  <div class="form-group">
                    <label>Descrição do Produto</label>
                    <input type="text" class="form-control" name="descricao" id="descricao" required value="<?php echo $descricao; ?>">
                  </div>
                  <div class="form-group">
                    <label>Preço</label>
                    <input type="text" class="form-control" name="preco" id="preco" required value="<?php echo $preco; ?>">
                  </div>

                  <div class="form-group">
                    <label>Foto do Produto</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="foto" id="foto">
                        <label class="custom-file-label">Arquivo de imagem</label>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="editprod" class="btn btn-primary">Finalizar Edição</button>
                </div>
              </form>
              <?php
              if (isset($_POST['editprod'])) {

                $nome = $_POST['nome'];
                $destino = $_POST['destino'];
                $origem = $_POST['origem'];
                $descricao = $_POST['descricao'];
                $preco = $_POST['preco'];

                if (!empty($_FILES['foto']['name'])) {

                  $formatP = array("png", "jpg", "jpeg", "gif");
                  $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

                  if (in_array($extensao, $formatP)) {

                    $pasta = "../img/";
                    $temporario = $_FILES['foto']['tmp_name'];
                    $novoNome = uniqid() . ".{$extensao}";

                    if (move_uploaded_file($temporario, $pasta . $novoNome)) {
                    } else {
                      $mensagem = "Erro, não foi possivel fazer o upload do arquivo!";
                    }
                  } else {
                    echo "Formato inválido";
                  }
                } else {
                  $novoNome = $foto;
                }
                $update = "UPDATE viagem SET nome=:nome,destino=:destino,origem=:origem,descricao=:descricao,preco=:preco,foto=:foto WHERE id=:id";
                try {

                  $result = $conect->prepare($update);
                  $result->bindParam(':id', $id, PDO::PARAM_STR);
                  $result->bindParam(':nome', $nome, PDO::PARAM_STR);
                  $result->bindParam(':destino', $destino, PDO::PARAM_STR);
                  $result->bindParam(':origem', $origem, PDO::PARAM_STR);
                  $result->bindParam(':descricao', $descricao, PDO::PARAM_STR);
                  $result->bindParam(':preco', $preco, PDO::PARAM_STR);
                  $result->bindParam(':foto', $novoNome, PDO::PARAM_STR);
                  $result->execute();

                  $contar = $result->rowCount();
                  if ($contar > 0) {
                    echo '<div class="container">
                                <div class="alert alert-success alert-dismissible">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  <h5><i class="icon fas fa-check"></i> Ok !!!</h5>
                                  Os dados foram atualizados com sucesso.
                                </div>
                                </div>';
                    header("Refresh: 5, home.php");
                  } else {
                    echo '<div class="alert alert-danger alert-dismissible">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  <h5><i class="icon fas fa-check"></i> Erro !!!</h5>
                                  Não foi possível atualizar os dados.
                                </div>';
                  }
                } catch (PDOException $e) {
                  echo "<strong>ERRO DE PDO= </strong>" . $e->getMessage();
                }
              }
              ?>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Dados da Viagem</h3>
              </div>
              <div class="card-body p-0" style="text-align: center; margin-bottom: 98px">
                <img src="../img/<?php echo $foto; ?>" alt="<?php echo $foto; ?>" title="<?php echo $foto; ?>" style="width: 300px; border-radius: 10%; margin-top: 30px">
                <h1><?php echo $nome; ?></h1>
                <h4><strong>Destino: </strong><?php echo $destino; ?></h4>
                <p>
                <h4><strong>Origem: </strong><?php echo $origem; ?></h4>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  </section>
  </div>