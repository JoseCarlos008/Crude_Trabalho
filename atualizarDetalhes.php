<?php
$userId = $_POST["userId"];
$nome = $_POST["nome"];
$passwd = $_POST["senha"];
$user = $_POST["nickName"];

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

    $sql = "UPDATE usuarios SET nome = :nome, nickName = :nickName, senha = :senha WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':nickName', $user);
    $stmt->bindParam(':senha', $passwd);

    if ($stmt->execute()) {
        echo "Registro atualizado.";
    } else {
        echo "Erro: " . $stmt->errorInfo()[2];
    }

    $conn = null;
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
