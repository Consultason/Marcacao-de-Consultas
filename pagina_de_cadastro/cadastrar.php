<?php
// Conecta ao banco
require_once "conexao.php";

// Recebe os valores enviados pelo formulário
$nome   = $_POST['nome'];
$cpf    = $_POST['cpf'];
$email  = $_POST['email'];
$tel    = $_POST['tel'];
$senha  = $_POST['senha'];

// Prepara o comando SQL
$sql = "INSERT INTO usuarios (nome, cpf, email, telefone, senha)
        VALUES ('$nome', '$cpf', '$email', '$tel', '$senha')";

if ($conn->query($sql) === TRUE) {
    // Se cadastrar com sucesso
    header("Location: ../pagina_de_login/login.html");
    exit;
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

$conn->close();
?>

