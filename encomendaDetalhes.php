<?php
include('server/config.php');
include('layout/header.php');

if (isset($_POST['encomendas-detalhes-btn']) && isset($_POST['encomenda_id'])) {
    $encomenda_id = $_POST['encomenda_id'];
    $encomenda_estado = $_POST['encomenda_estado'];

    $stmt = $conn->prepare("SELECT ed.*, p.nome, p.img1, e.utilizador_id, e.data FROM encomendas_detalhes ed inner join produtos p on p.ID=ed.produto_id inner join encomendas e on e.ID=ed.encomenda_id WHERE ed.encomenda_id = ?");
    $stmt->bind_param('i', $encomenda_id);
    $stmt->execute();
    $encomenda_detalhes = $stmt->get_result();
    $total_encomenda_preco = calcularTotalCarrinhoEncomenda($encomenda_detalhes);
} else {
    header('location: contaPessoal.php');
    exit;
}

function calcularTotalCarrinhoEncomenda($encomenda_detalhes)
{
    $total = 0;

    foreach ($encomenda_detalhes as $row) {
        $preco =  $row['preco'];
        $quantidade = $row['quantidade'];

        $total =  $total + ($preco * $quantidade);
    }
    return $total;
}
?>

<!--Encomendas detalhes-->
<section id="encomendas" class="encomendas container my-5 py-5">
    <div class="container mt-5">
        <h2 class="font-weight-bold text-center">Detalhes da Encomenda</h2>
        <hr class="mx-auto">
    </div>
    <table class="mt-5 pt-5 mx-auto">
        <tr>
            <th>Produto</th>
            <th>Preço</th>
            <th>Quantidade</th>
        </tr>

        <?php foreach ($encomenda_detalhes as $row) { ?>
            <tr>
                <td>
                    <div class="produto-info">
                        <img src="imgs/<?php echo $row['img1']; ?>" />
                        <div>
                            <p class="mt-3"><?php echo $row['nome']; ?></p>
                        </div>
                    </div>

                </td>
                <td>
                    <span><?php echo $row['preco']; ?> €</span>
                </td>

                <td>
                    <span><?php echo $row['quantidade']; ?></span>
                </td>

            </tr>
        <?php } ?>

    </table>
    <?php if ($encomenda_estado == "pendente") { ?>
        <form style="float: right;" method="POST" action="pagamentos.php">

            <input type="hidden" name="encomenda_id" value="<?php echo $encomenda_id; ?>" />

            <input type="hidden" name="total_encomenda_preco" value="<?php echo $total_encomenda_preco; ?>" />

            <input type="hidden" name="encomenda_estado" value="<?php echo $encomenda_estado; ?>" />

            <input type="submit" name="encomenda_btn" class="btn encomendas-detalhes-btn rounded shadow" value="Pagar" />
        </form>
    <?php } ?>

</section>

<?php include('layout/footer.php'); ?>