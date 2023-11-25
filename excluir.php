<?php

$jsonData = $_POST['data'];

$data = json_decode($jsonData, true);

$userId = $data['id'];

try {
    $host = "localhost";
    $database = "cedup";
    $username = "root";
    $password = "";

    $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $conn = new PDO($dsn, $username, $password, $options);

    $sql = "DELETE FROM usuarios WHERE id= :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId );

    if ($stmt->execute()) {
        echo "Registro Excluido.";
        echo json_encode(['status' => 'success']);
    } else {
        echo "Erro: " . $stmt->errorInfo()[2];
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }

    $conn = null;
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>