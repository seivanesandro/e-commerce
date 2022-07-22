<?php

include('server/config.php');
include('layout/header.php');
//se o utilizador usar a pesquisa
if (isset($_POST['search']) || isset($_GET["category"])) {

  if (isset($_GET["category"])) {
    if ($_GET["category"] == "T")
      $categoria = "Tennis";
    else if ($_GET["category"] == "M")
      $categoria = "Mochilas";
    else if ($_GET["category"] == "R")
      $categoria = "Smartwatch";
  }

  if (isset($_POST['search'])) {
    $categoria = $_POST['categoria'];
  }

  $stmt = $conn->prepare("SELECT p.*, c.descricao as categoria FROM produtos p inner join categorias c on c.ID=p.categoria_ID WHERE c.descricao = ? order by p.id");
  $stmt->bind_param("s", $categoria);
  $stmt->execute();
  $produtos = $stmt->get_result();
}
//se o utilizador nao usar a pesquisa retornar todos os produtos
else {
  $stmt = $conn->prepare("SELECT p.*, c.descricao as categoria FROM produtos p inner join categorias c on c.ID=p.categoria_ID order by p.id");
  $stmt->execute();
  $produtos = $stmt->get_result();
}
?>


<!--Search-->
<section id="search" class="my-5 py-5 ms-1">
  <div class="container mt-5 py-5">
    <p></p>
  </div>



  <!--categorias-->
  <form action="shop.php" method="POST">
    <div class="row mx-auto container">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <h4>Categorias</h4>

        <div class="form-check">
          <input class="form-check-input" value="Destaques" type="radio" name="categoria" id="categoria1" <?php if (isset($categoria) && $categoria == 'Destaques') {
                                                                                                            echo 'checked';
                                                                                                          } ?>>
          <label class="form-check-label" for="flexRadioDefault1">
            Destaques
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" value="Tennis" type="radio" name="categoria" id="categoria2" <?php if (isset($categoria) && $categoria == 'Tennis') {
                                                                                                          echo 'checked';
                                                                                                        } ?>>
          <label class="form-check-label" for="flexRadioDefault1">
            Tennis
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" value="Casacos" type="radio" name="categoria" id="categoria3" <?php if (isset($categoria) && $categoria == 'Casacos') {
                                                                                                          echo 'checked';
                                                                                                        } ?> />
          <label class="form-check-label" for="flexRadioDefault1">
            Casacos
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" value="Smartwatch" type="radio" name="categoria" id="categoria4" <?php if (isset($categoria) && $categoria == 'Smartwatch') {
                                                                                                              echo 'checked';
                                                                                                            } ?> />
          <label class="form-check-label" for="flexRadioDefault1">
            Smartwatches
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" value="Mochilas" type="radio" name="categoria" id="categoria5" <?php if (isset($categoria) && $categoria == 'Mochilas') {
                                                                                                            echo 'checked';
                                                                                                          } ?> />
          <label class="form-check-label" for="flexRadioDefault1">
            Mochilas
          </label>
        </div>

      </div>
    </div>
    <!-- botao -->
    <div class="form-group my-5 mx-4">
      <input type="submit" name="search" value="Pesquisar" class="btn search-btn rounded shadow">
    </div>
    <form>
</section>


<!--SHOP-->
<section id="shop" class="my-5 py-5">
  <div class="container text-center mt-5 py-5">
    <h3>Loja</h3>
    <hr class="mx-auto">
    <p>Os nossos Produtos</p>
  </div>

  <!--mochilas-->
  <div class="row mx-auto container">

    <?php while ($row = $produtos->fetch_assoc()) { ?>

      <!--produto 1-->
      <div onclick="window.location.href ='<?php echo "produtoU.php?produto_id=" . $row['ID']; ?>';" class="produto text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="imgs/<?php echo $row['img1']; ?>">
        <div class="star">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
        </div>
        <h5 class="p-nome"><?php echo $row['nome']; ?></h5>
        <h4 class="p-preco"><?php echo $row['preco']; ?> €</h4>
        <a class="btn comprar-btn rounded shadow mb-4" href="<?php echo "produtoU.php?produto_id=" . $row['ID']; ?>">Comprar</a>
      </div>

    <?php } ?>

    <!--Page navigation -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item"><a class="page-link disabled" href="#">&laquo;</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link disabled" href="#">2</a></li>
        <li class="page-item"><a class="page-link disabled" href="#">3</a></li>
        <li class="page-item"><a class="page-link disabled" href="#">&raquo;</a></li>
      </ul>
    </nav>
  </div>
</section>

<?php include('layout/footer.php'); ?>