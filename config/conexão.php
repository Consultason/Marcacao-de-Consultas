<?php
// conexao.php
session_start(); // importante para usar $_SESSION em todas as páginas

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "BemNordeste";

$conn = new mysqli($servidor, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Função para escapar saída (XSS)
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>
