
<?php

include('config.php');

$stmt = $conn->prepare("SELECT p.*, c.descricao as categoria FROM produtos p inner join categorias c on c.id = p.categoria_ID WHERE c.descricao LIKE 'Mochila%' LIMIT 4");

$stmt->execute();

$destaquesProdutos = $stmt->get_result();


?>