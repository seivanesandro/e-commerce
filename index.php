<?php include('layout/header.php'); ?>

<!--home-->
<section id="home">
  <div class="container">
    <h5><span>Nova Loja-Online</span></h5>
    <h1><span>Mind Style</span> Preços Inteligentes</h1>
    <p>“Satisfazer os clientes não é mais o suficiente: é preciso encantá-los.”</p>
    <a href="shop.php"><button class=" rounded shadow">Compras</button></a>
  </div>
</section>

<!--imagens logo roupas-->
<section id="brand" class="container">
  <div class="row m-0">
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="imgs/brand1.jpeg" />
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="imgs/brand2.jpeg" />
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="imgs/brand3.jpeg" />
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="imgs/brand4.jpeg" />
  </div>
</section>

<!--novos produtos animaçao-->
<section id="novo" class="w-100">
  <div class="row p-0 m-0">
    <!--primeiro-->
    <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
      <img class="img-fluid" src="imgs/1.jpeg" />
      <div class="detalhes">
        <h2>Tennis da Moda</h2>
        <a href="shop.php?category=T"><button class="text-uppercase rounded shadow">Comprar Agora</button></a>
      </div>
    </div>
    <!--segundo-->
    <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
      <img class="img-fluid" src="imgs/2.jpeg" />
      <div class="detalhes">
        <h2>Mochilas com Grande Estilo</h2>
        <a href="shop.php?category=M"><button class="text-uppercase rounded shadow">Comprar Agora</button></a>
      </div>
    </div>

    <!--terceiro-->
    <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
      <img class="img-fluid" src="imgs/3.jpeg" />
      <div class="detalhes">
        <h2>Relógios a 50%</h2>
        <a href="shop.php?category=R"><button class="text-uppercase rounded shadow">Comprar Agora</button></a>
      </div>
    </div>
  </div>
</section>

<!--Destaques Mochilas-->
<section id="destaques" class="my-5 pb-5">
  <div class="container text-center mt-5 py-5">
    <h3>Mochilas & Preços</h3>
    <hr class="mx-auto">
    <p>Clica para veres a nossa Gama de Mochilas</p>
  </div>
  <!--destaque 1-->
  <div class="row mx-auto container-fluid">
    <?php include('server/getDestaquesProdutos.php'); ?>
    <?php while ($row = $destaquesProdutos->fetch_assoc()) { ?>
      <div class="produto text-center col-lg-3 col-md-4 col-sm-12">
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
        <a href="<?php echo "produtoU.php?produto_id=" . $row['ID']; ?>"><button class="comprar-btn rounded shadow">Comprar</button></a>
      </div>

    <?php } ?>
  </div>
</section>

<!--banner-->
<section id="banner" class="my-5 py-5">
  <div class="container">
    <h4>Novidades</h4>
    <h1>Preços<br>com 50% de Desconto</h1>
    <button class="text-upercase rounded shadow">Comprar</button>
  </div>
</section>

<!--acessorios - casacos -->
<section id="destaques" class="my-5">
  <div class="container text-center mt-5 py-5">
    <h3>Casacos & Preços</h3>
    <hr class="mx-auto">
    <p>Clica para veres a nossa Gama de casacos</p>
  </div>
  <!--destaque 1-->
  <div class="row mx-auto container-fluid">

    <?php include('server/getCasacos.php'); ?>
    <?php while ($row = $casacos->fetch_assoc()) { ?>
      <div class="produto text-center col-lg-3 col-md-4 col-sm-12">
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
        <a href="<?php echo "produtoU.php?produto_id=" . $row['ID']; ?>"><button class="comprar-btn rounded shadow">Comprar</button></a>
      </div>
    <?php } ?>
  </div>
</section>
<!--acessorios - smartwatch -->
<section id="relogios" class="my-5">
  <div class="container text-center mt-5 py-5">
    <h3>SmartWatch & Preços</h3>
    <hr class="mx-auto">
    <p>Clica para veres a nossa Gama de smartwatch's</p>
  </div>
  <!--destaque 1-->
  <div class="row mx-auto container-fluid">
    <?php include('server/getRelogios.php'); ?>
    <?php while ($row = $Smartwatch->fetch_assoc()) { ?>
      <div class="produto text-center col-lg-3 col-md-4 col-sm-12">
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
        <a href="<?php echo "produtoU.php?produto_id=" . $row['ID']; ?>"><button class="comprar-btn rounded shadow">Comprar</button></a>
      </div>
    <?php } ?>
  </div>
</section>

<!--acessorios - Tennis -->
<section id="sapatos" class="my-5">
  <div class="container text-center mt-5 py-5">
    <h3>Tennis & Preços</h3>
    <hr class="mx-auto">
    <p>Clica para veres a nossa Gama de Tennis Desportivos</p>
  </div>
  <!--destaque 1-->
  <div class="row mx-auto container-fluid">
    <?php include('server/getTennis.php') ?>
    <?php while ($row = $tennis->fetch_assoc()) { ?>
      <div class="produto text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="imgs/<?php echo $row['img1'] ?>">
        <div class="star">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
        </div>
        <h5 class="p-nome"><?php echo $row['nome'] ?></h5>
        <h4 class="p-preco"><?php echo $row['preco'] ?> €</h4>
        <a href="<?php echo "produtoU.php?produto_id=" . $row['ID']; ?>"><button class="comprar-btn rounded shadow">Comprar</button></a>
      </div>

    <?php } ?>
  </div>
</section>

<?php include('layout/footer.php'); ?>