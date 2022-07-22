<?php

include('server/config.php');
include('layout/header.php');

if (isset($_GET['produto_id'])) {
  $produto_id =  $_GET['produto_id'];
  $stmt = $conn->prepare("SELECT p.*, c.descricao as categoria FROM produtos p inner join categorias c on c.ID = p.categoria_ID WHERE p.ID = ?");
  $stmt->bind_param("i", $produto_id);
  $stmt->execute();
  $produto = $stmt->get_result();
} else {
  header('location: index.php');
}
?>

<!--produto unico-->
<section class="container produto-unico my-5 pt-5">
  <div class="row mt-5">
    <?php while ($row = $produto->fetch_assoc()) { ?>
      <div class="col-lg-5 col-md-6 col-sm-12">
        <img class="img-fluid w-75 pb-1" src="imgs/<?php echo $row['img1'] ?>" id="mainImg">
        <div class="small-img-group">
          <div class="small-img-col">
            <img src="imgs/<?php echo $row['img1'] ?>" width="100%" class="small-img">
          </div>
          <div class="small-img-col">
            <img src="imgs/<?php echo $row['img2'] ?>" width="100%" class="small-img">
          </div>
          <div class="small-img-col">
            <img src="imgs/<?php echo $row['img3'] ?>" width="100%" class="small-img">
          </div>
          <div class="small-img-col">
            <img src="imgs/<?php echo $row['img4'] ?>" width="100%" class="small-img">
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-12 col-12">
        <h6><?php echo $row['categoria'] ?></h6>
        <h3 class="py-4"><?php echo $row['nome'] ?></h3>
        <h2><?php echo $row['preco'] ?> €</h2>

        <form method="POST" action="carrinho.php">
          <input type="hidden" name="produto_id" value="<?php echo $row['ID']; ?>">
          <input type="hidden" name="produto_img" value="<?php echo $row['img1'] ?>">
          <input type="hidden" name="produto_nome" value="<?php echo $row['nome'] ?>">
          <input type="hidden" name="produto_preco" value="<?php echo $row['preco'] ?>">

          <input type="number" name="produto_quantidade" value="1" />
          <button class="adicionar-btn rounded shadow" type="submit" name="adicionarCarrinho">Adicionar ao carrinho</button>
        </form>

        <h4 class="mt-5 mb-5">Detalhes do Produto</h4>
        <span><?php echo $row['descricao'] ?></span>
      </div>

    <?php } ?>
  </div>
</section>

<!--produtos relacionados-->
<section id="RelatProduto" class="my-5 pb-5">
  <div class="container text-center mt-5 py-5">
    <h3>Produtos Relacionados</h3>
    <hr class="mx-auto">
  </div>
  <!--destaque 1-->
  <div class="row mx-auto container-fluid">
    <div class="produto text-center col-lg-3 col-md-4 col-sm-12">
      <img class="img-fluid mb-3" src="imgs/destaque1.png">
      <div class="star">
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
      </div>
      <h5 class="p-nome">Tennis Desportivos</h5>
      <h4 class="p-preco">199.8 €</h4>
      <button class="comprar-btn rounded">Comprar</button>
    </div>

    <!--destaque 2-->
    <div class="produto text-center col-lg-3 col-md-4 col-sm-12">
      <img class="img-fluid mb-3" src="imgs/destaque2.png">
      <div class="star">
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
      </div>
      <h5 class="p-nome">Mochila desportiva da Puma - Azul</h5>
      <h4 class="p-preco">59 €</h4>
      <button class="comprar-btn rounded">Comprar</button>
    </div>

    <!--destaque 3-->
    <div class="produto text-center col-lg-3 col-md-4 col-sm-12">
      <img class="img-fluid mb-3" src="imgs/destaque3.png">
      <div class="star">
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
      </div>
      <h5 class="p-nome">Mochila desportiva da Puma - dark</h5>
      <h4 class="p-preco">49 €</h4>
      <button class="comprar-btn rounded">Comprar</button>
    </div>

    <!--destaque 4-->
    <div class="produto text-center col-lg-3 col-md-4 col-sm-12">
      <img class="img-fluid mb-3" src="imgs/destaque4.png">
      <div class="star">
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
      </div>
      <h5 class="p-nome">Mochila desportiva Nike</h5>
      <h4 class="p-preco">80 €</h4>
      <button class="comprar-btn rounded">Comprar</button>
    </div>
  </div>
</section>

<!--script imagens animaçao-->
<script>
  var mainImg = document.getElementById("mainImg");
  var smallImg = document.getElementsByClassName("small-img");

  for (let i = 0; i < 4; i++) {
    smallImg[i].onclick = function() {
      mainImg.src = smallImg[i].src;
    }
  }
</script>

<?php include('layout/footer.php'); ?>