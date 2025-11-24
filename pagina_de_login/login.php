<?php
//  login SEM banco de dados

$email_correto = "admin@teste.com";
$senha_correta = "123456";

$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";

// Verificação simples
if ($email === $email_correto && $senha === $senha_correta) {
    header("Location: ../pagina_de_marcação_de_consultas/marcação.html");
    exit;
} else {
    // Volta para o login com mensagem de erro
    echo "
        <script>
            alert('E-mail ou senha incorretos!');
            window.location.href = 'login.html';
        </script>
    ";
    exit;
}
?>
