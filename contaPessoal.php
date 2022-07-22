<?php

include('server/config.php');
include('layout/header.php');

if (!@isset($_SESSION['logged_in'])) {
  header('location: login.php');
  exit;
}

$message = "";
if (@isset($_GET['message'])) {
  if ($_GET['message'] == "sucesso")
    $message = "Password actualizada com sucesso";
  elseif ($_GET['message'] == "insucesso")
    $message = "Não é possivel alterar password";
} 

if (isset($_GET['logout'])) {
  if (isset($_SESSION['logged_in'])) {
    unset($_SESSION['logged_in']);
    unset($_SESSION['utilizador_email']);
    unset($_SESSION['utilizador_nome']);
    header('location: index.php');
    exit;
  }
}

if (isset($_POST['alterar_password'])) {
  $pw = $_POST['password'];
  $password = hash('sha256', $pw);
  $confirmaPassword = hash('sha256', $_POST['confirmaPassword']);
  $utilizador_email = $_SESSION['utilizador_email'];

  //se as passwords nao forem iguais
  if ($password !== $confirmaPassword) {
    header('location: contaPessoal.php?erro_pw=noMatch');
  }

  //se a password nao tiver 6 carateres 
  else if (strlen($pw) < 6) {
    header('location: contaPessoal.php?erro_pw=length');
  } else {
    $stmt = $conn->prepare("UPDATE utilizadores SET password = ? WHERE email = ?");
    $stmt->bind_param('ss', $password, $utilizador_email);

    if ($stmt->execute()) {
      header('location: contaPessoal.php?message=sucesso');
    } else {
      header('location: contaPessoal.php?message=insucesso');
    }
  }
}

//GET encomendas
if (isset($_SESSION['logged_in'])) {

  $login_sucesso="";
  $regista_sucesso ="";
  $erro_pw = "";
  
//login
  if (@isset($_GET['login_sucesso']) && $_GET['login_sucesso'] == "sim")
  {
        $login_sucesso = "<span style='color:green;'>Login efetuado com sucesso!</span>";
  }
  
//regista
  if (@isset($_GET['regista_successo']) && $_GET['regista_successo'] == "sim") {
        
        $regista_sucesso = "<span style='color:green;'>Registo efetuado com sucesso!</span>";
  } 
  
// passwords
  if (@isset($_GET['erro_pw']) && $_GET['erro_pw'] == "noMatch") {

        $erro_pw = "<span style='color:green;'>As passwords são diferentes!</span>";
  }
  else if (@isset($_GET['erro_pw']) && $_GET['erro_pw'] == "length")
         $erro_pw = "<span style='color:green;'>As passwords tem de conter mais de 6 caracteres!</span>";


  $utilizador_id = $_SESSION['utilizador_id'];
  $stmt = $conn->prepare("SELECT e.*, u.telefone, u.cidade, u.morada FROM encomendas e inner join utilizadores u on u.ID=e.utilizador_ID where u.ID = ? ");
  $stmt->bind_param('i', $utilizador_id);
  $stmt->execute();
  $encomendas = $stmt->get_result(); //[]
}
?>
<!--Conta Pessoal-->
<section class="my-5 py-5">
  <!-- painel do utilizador -->
  <div class="row container mx-auto">
    <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">

      <label class="text-center" style="color:green"><strong><?php if (isset($_GET['login_sucesso'])) {echo $login_sucesso;} ?></strong></label>
      <label class="text-center" style="color:green"><strong><?php if (isset($_GET['regista_successo'])) {echo $regista_sucesso;}?></strong></label>
      
      <h3 class="font-weight-bold">Conta Pessoal</h3>
      <hr class="mx-auto">
      <div class="conta-info">
        <p>Nome: <span><strong><?php if (isset($_SESSION['utilizador_nome'])) {echo $_SESSION['utilizador_nome']; } ?></strong></span></p>
        <p>Email: <span><strong><?php if (isset($_SESSION['utilizador_email'])) { echo $_SESSION['utilizador_email']; } ?></strong></span></p>
        <p><a href="#encomendas" id="encomendas-btn">As tuas Ordens</a></p>
        <p><a href="contaPessoal.php?logout=1" id="logout-btn">Logout</a></p>
      </div>
    </div>
    <!--conta pessoal alterar Password-->
    <div class="col-lg-6 col-md-12 col-sm-12">
      <form id="conta-form" method="POST" action="contaPessoal.php">
        <p class="text-center" style="color:red"><strong><?php if (isset($_GET['erro_pw'])) { echo $erro_pw; } ?></strong></p>
        <p class="text-center" style="color:green"><strong><?php if (isset($_GET['message'])) {echo $message; } ?></strong></p>
        <h3>Alterar Password</h3>
        <hr class="mx-auto">
        <div class="form-group">
          <label for="">Password</label>
          <input type="password" class="form-control" id="conta-password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
          <label for="">Confirmar Password</label>
          <input type="password" class="form-control" id="conta-password-confirm" name="confirmaPassword" placeholder="Confirmar Password" required>
        </div>
        <div class="form-group">
          <input type="submit" value="Alterar Password" name="alterar_password" class="btn rounded shadow" id="alterar-pw-btn">
        </div>
      </form>
    </div>
  </div>
</section>

<!--Encomendas-->
<section id="encomendas" class="encomendas container my-5 py-3">
  <div class="container mt-2">
    <h2 class="font-weight-bold text-center">As suas Encomendas</h2>
    <hr class="mx-auto">
  </div>
  <table class="mt-5 pt-5">
    <tr>
      <th>Encomendas</th>
      <th>Preço</th>
      <th>Estado</th>
      <th>Data</th>
      <th>Detalhes da Encomenda</th>
    </tr>

    <?php while ($row = $encomendas->fetch_assoc()) { ?>

      <tr>
        <td>
          <span><?php echo $row['ID']; ?></span>
        </td>
        <td>
          <span><?php echo $row['preco']; ?> €</span>
        </td>

        <td>
          <span><?php echo $row['estado']; ?></span>
        </td>

        <td>
          <span><?php echo $row['data']; ?></span>
        </td>
        <td>
          <form method="POST" action="encomendaDetalhes.php">
            <input type="hidden" value="<?php echo $row['estado']; ?>" name="encomenda_estado">
            <input type="hidden" value="<?php echo $row['ID']; ?>" name="encomenda_id" />
            <input class="btn encomendas-detalhes-btn rounded shadow" name="encomendas-detalhes-btn" type="submit" value="Detalhes" />
          </form>
        </td>
      </tr>
    <?php } ?>

  </table>
</section>

<?php include('layout/footer.php'); ?>