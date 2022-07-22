<?php

session_start();

include('config.php');

if(isset($_GET['transaction_id']) && isset($_GET['encomenda_id'])){

    $encomenda_id = $_GET['encomenda_id'];
    $encomenda_estado = "pago";
    $transaction_id = $_GET['transaction_id'];



    //mudar estado da encomenda para pago
    $stmt = $conn->prepare("UPDATE encomendas SET estado = ?, transaccao_id = ? WHERE ID = ?");
    $stmt->bind_param('ssi', $encomenda_estado, $transaction_id, $encomenda_id);


    $stmt->execute();

    //voltar a conta do utilizador
    header("location: ../pagamentoEfectuado.php");

}else{
    header("location: ../index.php");
    exit;
}






?>