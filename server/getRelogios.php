
<?php

include('config.php');

$stmt = $conn->prepare("SELECT p.* FROM produtos p inner join categorias c on c.id = p.categoria_ID WHERE c.descricao Like 'Smartwatch' LIMIT 4");

$stmt->execute();

$Smartwatch = $stmt->get_result();


?>