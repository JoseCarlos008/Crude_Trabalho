<?php
/*
 * Método de conexão sem padrões
*/

$username = "root";
$password = "";

try {
    $conn = new PDO('mysql:host=localhost;dbname=cedup', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtenha o ID do usuário da requisição AJAX
    $userId = json_decode($_POST['data'])->id;

    // Prepare a consulta SQL
    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE id = :id');
    $stmt->execute(array('id' => $userId));

    // Obtenha o resultado
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retorne o resultado como um objeto JSON
    echo json_encode($result);
    
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>