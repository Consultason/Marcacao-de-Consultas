<?php
// Variável que armazena o endereço do servidor MySQL (normalmente localhost)
$servidor = "localhost";

// Usuário do banco de dados (padrão do XAMPP/WAMP é "root")
$usuario = "root";

// Senha do banco de dados (vazia por padrão no XAMPP/WAMP)
$senha = "";

// Nome do banco de dados que será utilizado
$banco = "BemNordeste";

// Cria a conexão com o banco usando a extensão MySQLi
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica se ocorreu algum erro na conexão
if($conn->connect_error){
    // Encerra o script e exibe a mensagem de erro
    die("Erro na conexão: " . $conn->connect_error);
}
?>

