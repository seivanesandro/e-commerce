<?php
include('layout/header.php');


if (isset($_POST['adicionarCarrinho'])) {
    if (isset($_SESSION['carrinho'])) {
        $produto_array_ids = array_column($_SESSION['carrinho'], "produto_id");
        if (!in_array($_POST['produto_id'], $produto_array_ids)) {
            $produto_id = $_POST['produto_id'];

            $produto_array = array(
                'produto_id' => $_POST['produto_id'],
                'produto_nome' =>  $_POST['produto_nome'],
                'produto_preco' => $_POST['produto_preco'],
                'produto_img' => $_POST['produto_img'],
                'produto_quantidade' => $_POST['produto_quantidade']
            );

            $_SESSION['carrinho'][$produto_id] = $produto_array;
        } else {

            echo '<script>alert("Produto já adicionado ao carrinho");</script>';
        }
    } else {
        $produto_id = $_POST['produto_id'];
        $produto_nome = $_POST['produto_nome'];
        $produto_preco = $_POST['produto_preco'];
        $produto_img = $_POST['produto_img'];
        $produto_quantidade = $_POST['produto_quantidade'];

        $produto_array = array(
            'produto_id' => $produto_id,
            'produto_nome' => $produto_nome,
            'produto_preco' => $produto_preco,
            'produto_img' => $produto_img,
            'produto_quantidade' => $produto_quantidade
        );

        $_SESSION['carrinho'][$produto_id] = $produto_array;
    }

    calcularTotalCarrinho();
} else if (isset($_POST['remover_produto'])) {
    $produto_id = $_POST['produto_id'];
    unset($_SESSION['carrinho'][$produto_id]);

    calcularTotalCarrinho();
} else if (isset($_POST['editar_quantidade'])) {
    $produto_id = $_POST['produto_id'];
    $produto_quantidade = $_POST['produto_quantidade'];
    $produto_array = $_SESSION['carrinho'][$produto_id];
    $produto_array['produto_quantidade'] = $produto_quantidade;

    $_SESSION['carrinho'][$produto_id] = $produto_array;

    calcularTotalCarrinho();
} else {

    //header('location: index.php');
}
function calcularTotalCarrinho()
{

    $totalPreco = 0;
    $totalQuantidade = 0;

    foreach ($_SESSION['carrinho'] as $key => $value) {
        $produto =  $_SESSION['carrinho'][$key];

        $preco =  $produto['produto_preco'];
        $quantidade = $produto['produto_quantidade'];

        $totalPreco =  $totalPreco + ($preco * $quantidade);
        $totalQuantidade = $totalQuantidade + $quantidade;
    }

    $_SESSION['total'] = $totalPreco;
    $_SESSION['quantidade'] = $totalQuantidade;
}

?>

<!--carrinho-->
<section class="carrinho container my-5 py-5">
    <div class="container text-center mt-5">
        <h2 class="font-weight-bold">O seu Carrinho</h2>
        <hr class="mx-auto">
    </div>
    <table class=" mt-5 pt-5">
        <tr>
            <th>Produtos</th>
            <th>Quantidade</th>
            <th>Total a pagar</th>
        </tr>
        <?php if (isset($_SESSION['carrinho'])) { ?>
            <?php foreach ($_SESSION['carrinho'] as $key => $value) { ?>
                <tr>
                    <td>
                        <div class="produto-info">
                            <img src="imgs/<?php echo $value['produto_img']; ?>" />
                            <div>
                                <div>
                                    <p><strong><?php echo $value['produto_nome']; ?></strong></p>
                                    <label><strong><?php echo $value['produto_preco']; ?>€</strong></label>
                                </div>
                                <br>
                                <!-- remover produto -->
                                <form method="POST" action="carrinho.php">
                                    <input type="hidden" name="produto_id" value="<?php echo $value['produto_id']; ?>" />
                                    <input type="submit" name="remover_produto" class="remover-btn" value="remover" />
                                </form>
                            </div>
                        </div>
                    </td>
                    <td>
                        <!-- editar produto -->
                        <form method="POST" action="carrinho.php">
                            <input type="hidden" name="produto_id" value="<?php echo $value['produto_id']; ?>" />
                            <input type="number" name="produto_quantidade" value="<?php echo $value['produto_quantidade']; ?>" />
                            <input type="submit" name="editar_quantidade" class="editar-btn" value="editar" />
                        </form>
                    </td>
                    <td>
                        <strong> <span class="produto-preco"><?php echo $value['produto_quantidade'] * $value['produto_preco']; ?></span></strong>
                        <strong> <span>€</span></strong>

                    </td>
                </tr>

            <?php } ?>
        <?php } ?>

    </table>
    <!--carrinho total-->
    <div class="carrinho-total">
        <table>
            <tr>
                <td><strong>Total:</strong></td>
                <?php if (isset($_SESSION['carrinho'])) { ?>
                    <td><strong><?php echo $_SESSION['total']; ?> €</strong></td>
                <?php } ?>
            </tr>
        </table>
    </div>
    <div class="validar-container">
        <form method="POST" action="checkout.php">
            <input type="submit" class="btn validar-btn rounded shadow" value="Checkout" name="checkout" />
        </form>
    </div>
</section>


<?php include('layout/footer.php'); ?>