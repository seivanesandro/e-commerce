<?php
include('server/config.php');
include('layout/header.php');

if (isset($_SESSION['logged_in'])) {
  header('location: ContaPessoal.php');
  exit;
}

$error = "";
if (isset($_GET["error"])) {
  if ($_GET["error"] == "failedCredentials")
    $error = "ERRO: Email ou password incorrectos";
  if ($_GET["error"] == "uknownError")
    $error = "Ocorreu um erro a fazer o login!";
}

if (isset($_POST['login_btn'])) {


  $email = $_POST['email'];
  $password = hash('sha256', $_POST['password']);

  $stmt = $conn->prepare("SELECT ID,nome, email, password FROM utilizadores WHERE email = ? AND password = ? LIMIT 1");

  $stmt->bind_param('ss', $email, $password);

  if ($stmt->execute()) {
    $stmt->bind_result($utilizador_id, $utilizador_nome, $utilizador_email, $utilizador_password);
    $stmt->store_result();

    if ($stmt->num_rows() == 1) {
      $stmt->fetch();

      $_SESSION['utilizador_id'] = $utilizador_id;
      $_SESSION['utilizador_nome'] = $utilizador_nome;
      $_SESSION['utilizador_email'] = $utilizador_email;
      $_SESSION['logged_in'] = true;


      header('location: contaPessoal.php?login_sucesso=sim');
    } else {
      header('location: login.php?error=failedCredentials');
      //header('location: login.php?error=<script type="text/javascript">window.onload = function () { alert("wrong password"); }</script>');
    }
  } else {
    //error
    header('location: login.php?error=uknownError');
  }
}
?>

<!--Login-->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="form-weight-bold">Login</h2>
    <hr class="mx-auto">
  </div>
  <div class="mx-auto container">
    <form id="login-form" method="POST" action="login.php">
      <p style="color:red" class="text-center"><strong><?php echo $error; ?></strong></p>
      <div class="form-group">
        <label for="">Email</label>
        <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required>
      </div>
      <div class="form-group">
        <label for="">Password</label>
        <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
      </div>
      <div class="form-group">
        <input type="submit" class="btn rounded shadow" id="login-btn" name="login_btn" value="Login">
      </div>
      <div class="form-group">
        <label>Não Tem Conta? </label><a id="registar-url" class="btn" href="registar.php">Registe Aqui</a>
      </div>
    </form>
  </div>
</section>

<?php include('layout/footer.php'); ?>