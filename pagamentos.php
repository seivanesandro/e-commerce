<?php

include('layout/header.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    echo "<span>É necessario efectuar login</span>";
    exit;
}

if (isset($_POST['encomenda_btn'])) {
    $encomenda_estado = $_POST['encomenda_estado'];
    $total_encomenda_preco = $_POST['total_encomenda_preco'];
}

?>

<!--pagamentos-->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Pagamentos</h2>
        <hr class="mx-auto">
    </div>

    <!--total a pagar-->
    <div class="mx-auto container text-center">
        <!-- se o estado se encontra pendente -->
        <?php if (isset($_POST['encomenda_estado']) && $_POST['encomenda_estado'] == "pendente") { ?>
            <?php $montante = strval($_POST['total_encomenda_preco']); ?>
            <?php $encomenda_id = $_POST['encomenda_id']; ?>
            <p><strong>Total a Pagar: <?php echo $_POST['total_encomenda_preco']; ?> €</strong></p>
            <!-- <input type="submit" class="btn btn-primary" value="PAGAR" /> -->
            <!-- Set up a container element for the button -->
            <div id="paypal-button-container"></div>

            <!-- se houver algo no carrinho e o total diferente de 0 -->
        <?php } else if (isset($_SESSION['total']) && $_SESSION['total'] != 0) { ?>
            <?php $montante = strval($_SESSION['total']); ?>
            <?php $encomenda_id = $_SESSION['encomenda_id']; ?>
            <p><strong>Total a Pagar: <?php echo $_SESSION['total']; ?> €</strong></p>
            <!-- Set up a container element for the button -->
            <div id="paypal-button-container"></div>

            <!-- nao existem ordens -->
        <?php } else { ?>
            <p>Sem Encomendas</p>
        <?php } ?>


    </div>
</section>

<!--PAYPAL src-->
<!-- Include the PayPal JavaScript SDK; replace "test" with your own sandbox Business account app client ID -->
<script src="https://www.paypal.com/sdk/js?&client-id=AecJZPeZqvAS2YV9QvklBH7-sp-ZzMYk3IL8OJK57iClPQqAN4wxAS7WyAlWyfdhnYEPdYYCVepcI8w0&currency=EUR"></script>

<!--paypal api-->
<script>
    paypal.Buttons({

        // Sets up the transaction when a payment button is clicked
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $montante; ?>' // Can reference variables or functions. Example: `value: document.getElementById('...').value`
                    }
                }]
            });
        },

        // Finalize the transaction after payer approval
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                // Successful capture! For dev/demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                var transaction = orderData.purchase_units[0].payments.captures[0];
                alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                window, location.href = "server/pagamentoCompleto.php?transaction_id=" + transaction.id + "&encomenda_id=" + <?php echo $encomenda_id; ?>;
                // When ready to go live, remove the alert and show a success message within this page. For example:
                // var element = document.getElementById('paypal-button-container');
                // element.innerHTML = '';
                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                // Or go to another URL:  actions.redirect('thank_you.html');
            });
        }
    }).render('#paypal-button-container');
</script>
<?php include('layout/footer.php'); ?>