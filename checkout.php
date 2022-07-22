<?php

include('server/config.php');
include('layout/header.php');


if (!isset($_SESSION['logged_in'])) {
  header('location: login.php');
  echo "<span>É necessario efectuar login</span>";
  exit;
}

$message = "";
if (isset($_GET['message']) && $_GET['message'] == "login") {
  $message = "<span>Efetue o login para proceder a sua compra</span>";
}

if (!empty($_SESSION['carrinho'])) {
  //echo 'Faça aqui a sua encomenda';
  //header('location: index.php?msg="Carrinho vazinho"');
} else {
  //echo '<script>alert("Atenção o seu carrinho está vazio!");</script>';
  header('location: index.php');
}

$utilizador_id = $_SESSION['utilizador_id'];
$stmt = $conn->prepare("SELECT nome, email, telefone, cidade, morada from utilizadores WHERE ID = ?");
//Os argumentos a ser passados no bind_parameter podem ser de 4 tipos: i - integer, d - double, s - string, b - BLOB
$stmt->bind_param('i', $utilizador_id);
$stmt->execute();
$utilizador = $stmt->get_result();
?>

<!--CheckOut-->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="form-weight-bold">Faça a sua Encomenda</h2>
    <hr class="mx-auto">
  </div>

  <!--formulario  dados do utilizador -->
  <div class="mx-auto container">
    <form id="checkout-form" method="POST" action="server/encomenda.php">


      <p class="text-center" style="color:red;"><?php echo $message ?></p>
      <?php if (isset($_GET['message'])) { ?>

        <a href="login.php" class="btn btn-primary"></a>

      <?php } ?>

      <?php while ($row = $utilizador->fetch_assoc()) { ?>
        <div class="form-group checkout-small-element">
          <label for="">Nome</label>
          <input type="text" class="form-control" id="checkout-nome" name="nome" value='<?php echo $row['nome'] ?>' placeholder="Nome" disabled>
        </div>
        <div class="form-group checkout-small-element">
          <label>Email</label>
          <input type="text" class="form-control" id="checkout-email" name="email" value='<?php echo $row['email'] ?>' placeholder="Email" disabled>
        </div>
        <div class="form-group checkout-small-element">
          <label>Telefone</label>
          <input type="tel" class="form-control" id="checkout-telefone" name="telefone" value='<?php echo $row['telefone'] ?>' placeholder="Telefone" required>
        </div>
        <div class="form-group checkout-small-element">
          <label>Cidade</label>
          <input type="text" class="form-control" id="checkout-cidade" name="cidade" value='<?php echo $row['cidade'] ?>' placeholder="Cidade" required>
        </div>
        <div class="form-group checkout-large-element">
          <label>Morada</label>
          <input type="text" class="form-control" id="checkout-morada" name="morada" value='<?php echo $row['morada'] ?>' placeholder="Morada" required>
        </div>
        <div class="form-group checkout-btn-container">
          <strong>
            <p>Total: <?php echo $_SESSION['total']; ?> €</p>
          </strong>
          <input type="submit" class="btn rounded shadow" id="checkout-btn" name="encomendar" value="Encomendar">
        </div>
      <?php } ?>
    </form>
  </div>
</section>

<?php include('layout/footer.php'); ?>