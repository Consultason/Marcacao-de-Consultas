<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "BemNordeste";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão com o banco: " . $conn->connect_error);
}
?>
