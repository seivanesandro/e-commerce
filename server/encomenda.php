<?php
session_start();

include('config.php');

//se o utilizador nao esta logado
if(!isset($_SESSION['logged_in']))
{
       header('location: ../checkout.php?message=login');
      exit;
}

//se o utilizador esta logado
 else {

      if(isset($_POST['encomendar']))
      {
         //guarda novas encomendas na DB
         $encomenda_preco = $_SESSION['total'];
         $encomenda_estado = "pendente";
         $encomenda_data = date('Y-m-d H:i:s');
         $utilizador_id = $_SESSION['utilizador_id'];
         
         $stmt = $conn->prepare("INSERT INTO encomendas (preco,estado,data,utilizador_id)
                        VALUES (?,?,?,?);");
         //Os argumentos a ser passados no bind_parameter podem ser de 4 tipos: i - integer, d - double, s - string, b - BLOB
         $stmt->bind_param('dssi', $encomenda_preco,$encomenda_estado,$encomenda_data,$utilizador_id);

         $stmt_estado = $stmt->execute();

         if(!$stmt_estado)
          {
            header('location: index.php');
            exit;
          }



         #o insert_id retorna o id gerado automaticamente na última consulta (neste caso no query insert)
         $encomenda_id = $stmt->insert_id;
         // echo $encomenda_id;

         //guarda informaçao de utilizadores na DB
         $telefone = $_POST['telefone'];
         $cidade = $_POST['cidade'];
         $morada = $_POST['morada'];

         $stmt = $conn->prepare("UPDATE utilizadores set telefone = ?, cidade = ?, morada =? where ID = ?");
         //Os argumentos a ser passados no bind_parameter podem ser de 4 tipos: i - integer, d - double, s - string, b - BLOB
         $stmt->bind_param('sssi', $telefone, $cidade, $morada, $utilizador_id);

         $stmt->execute();

         
      //produtos do carrinho(sessao)
         foreach($_SESSION['carrinho'] as $key => $value)
         {
            $produto = $_SESSION['carrinho'][$key];
            $produto_id = $produto['produto_id'];
            $produto_preco = $produto['produto_preco'];
            $produto_quantidade = $produto['produto_quantidade'];
      //guarda um produto unico na encomendas_detalhes da DB
            $stmt1 = $conn->prepare("INSERT INTO encomendas_detalhes (encomenda_id,produto_id,preco,quantidade)
                              VALUE (?,?,?,?);");
            $stmt1->bind_param('iidi',$encomenda_id,$produto_id,$produto_preco, $produto_quantidade);

            $stmt1->execute();
         }

      //remover tudos os artigos do carrinho após o pagamento 
         unset($_SESSION['carrinho']);
         unset($_SESSION['quantidade']);
     

         $_SESSION['encomenda_id'] =  $encomenda_id;
         
         
         header('location: ../pagamentos.php');
      }
 }

?>