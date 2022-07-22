<?php
include('server/config.php');
include('layout/header.php');

$error = "";

if (isset($_GET["error"])) {
  if ($_GET["error"] == "noMatch")
    $error = "Passwords diferentes";
  else if ($_GET["error"] == "length")
    $error = "Password tem de conter pelo menos 6 caracteres";
  else if ($_GET["error"] == "unknownError")
    $error = "Não foi possivel registar a conta de momento";
}

if (isset($_SESSION['logged_in'])) {
  header('location: contaPessoal.php');
  exit;
}

if (isset($_POST['registar'])) {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $pw = $_POST['password'];
  $password = hash('sha256', $pw);
  $confirmaPassword = hash('sha256', $_POST['confirmaPassword']);
  $telefone = $_POST['telefone'];
  $cidade = $_POST['cidade'];
  $morada = $_POST['morada'];


  //se as passwords nao forem iguais
  if ($password !== $confirmaPassword) {
    header('location: registar.php?error=noMatch');
  }

  //se a password nao tiver 6 carateres 
  else if (strlen($pw) < 6) {
    header('location: registar.php?error=length');
  }

  //se nao houver erro
  else {
    //verificar se existe utilizador com o email igual
    $stmt1 = $conn->prepare("SELECT count(*) FROM utilizadores where email = ?");
    $stmt1->bind_param('s', $email);
    $stmt1->execute();
    $stmt1->bind_result($num_rows);
    $stmt1->store_result();
    $stmt1->fetch();

    //se ja existe um utilizador registado com este email
    if ($num_rows != 0) {
      header('location: registar.php?error="Este email já se encontra registado"');
    }
    //se nao exister utilizador registado com email
    else {
      //criar um novo utilizador
      $stmt = $conn->prepare("INSERT INTO utilizadores (nome,email,password,telefone,cidade,morada)
                                VALUES (?,?,?,?,?,?)");
      $stmt->bind_param('sssiss', $nome, $email, $password, $telefone, $cidade, $morada);

      //se a conta foi criada com sucesso
      if ($stmt->execute()) {

        $utilizador_id = $stmt->insert_id;
        $_SESSION['utilizador_id'] = $utilizador_id;
        $_SESSION['utilizador_email'] = $email;
        $_SESSION['utilizador_nome'] = $nome;
        $_SESSION['utilizador_telefone'] = $telefone;
        $_SESSION['utilizador_cidade'] = $cidade;
        $_SESSION['utilizador_morada'] = $morada;
        $_SESSION['logged_in'] = true;

        header('location: contaPessoal.php?regista_successo=sim');
      }

      //conta não criada
      else {
        header('location: registar.php?error=unknownError');
      }
    }
  }
}

?>

<!--Resgistar-->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="form-weight-bold">Registar Conta</h2>
    <hr class="mx-auto">
  </div>
  <div class="mx-auto container">
    <form id="registar-form" method="POST" action="registar.php">
      <p><strong style='color: red;'><?php echo $error; ?></strong></p>
      <div class="form-group">
        <label><strong>Name</strong></label>
        <input type="text" class="form-control" id="registar-name" name="nome" placeholder="Nome" required />
      </div>

      <div class="form-group">
        <label><strong>Email</strong></label>
        <input type="text" class="form-control" id="registar-email" name="email" placeholder="Email" required />
      </div>

      <div class="form-group">
        <label><strong>Password</strong></label>
        <input type="password" class="form-control" id="registar-password" name="password" placeholder="Password" required />
      </div>

      <div class="form-group">
        <label><strong>Confirmar Password</strong></label>
        <input type="password" class="form-control" id="registar-confirma-password" name="confirmaPassword" placeholder="Confirmar Password" required />
      </div>

      <div class="form-group">
        <label><strong>Telefone</strong></label>
        <input type="text" class="form-control" id="registar-telefone" name="telefone" placeholder="Telefone" required />
      </div>

      <div class="form-group">
        <label><strong>Morada</strong></label>
        <input type="text" class="form-control" id="registar-morada" name="morada" placeholder="Morada" required />
      </div>

      <div class="form-group">
        <label><strong>Cidade</strong></label>
        <input type="text" class="form-control" id="registar-cidade" name="cidade" placeholder="Cidade" required />
      </div>

      <div class="form-group">
        <input type="submit" class="btn rounded shadow" id="registar-btn" name="registar" value="Registar" />
      </div>

      <div class="form-group">
        <label>Já tem conta?<a id="login-url" href="login.php" class="btn"> Login</a></label>
      </div>
    </form>
  </div>
</section>

<?php include('layout/footer.php'); ?>