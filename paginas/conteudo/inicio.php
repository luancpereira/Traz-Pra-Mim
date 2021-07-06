  <div class="content-wrapper">
    <setion class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        </div>
      </div>
    </setion>
    <section class="content">
      <div class="container-fluid">

        <div class="card card-primary">
          <div class="card-header" style="background-color: #F26868;">
            <h3 class="card-title">Todas as Viagens</h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Foto</th>
                  <th>Produto</th>
                  <th>Descrição</th>
                  <th>Destino</th>
                  <th>Origem</th>
                  <th>Valor</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $select = "SELECT * FROM viagem ORDER BY destino ASC";
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
                        <td><img src="../img/<?php echo $show->foto; ?>" alt="<?php echo $show->foto; ?>" title="<?php echo $show->foto; ?>" style="width: 200px; border-radius: 10%;"></td>
                        <td><?php echo $show->nome; ?></td>
                        <td><?php echo $show->descricao; ?></td>
                        <td><?php echo $show->destino; ?></td>
                        <td><?php echo $show->origem; ?></td>
                        <td><?php echo $show->preco; ?></td>

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
  </section>
  <section class="content">
    <div class="container-fluid">

    </div>
    </div>
  </section>
  </div>