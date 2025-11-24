<?php
//  login SEM banco de dados

// Usuário 1 (principal)
$email_correto = "admin@teste.com";   // e-mail do usuário 1
$senha_correta = "123456";            // senha do usuário 1

// Usuário 2 (que você pediu)
$email2 = "joelhenrique519@gmail.com";  // e-mail do usuário 2
$senha2 = "joel519";                    // senha do usuário 2

// Usuário 3
$email3 = "paulo@gmail.com";   // e-mail do usuário 3
$senha3 = "paulo12";               // senha do usuário 3

// Usuário 4
$email4 = "usuario2@teste.com";   // e-mail do usuário 4
$senha4 = "senha2";               // senha do usuário 4

// Usuário 5
$email5 = "usuario3@teste.com";   // e-mail do usuário 5
$senha5 = "senha3";               // senha do usuário 5

// Usuário 6
$email6 = "usuario4@teste.com";   // e-mail do usuário 6
$senha6 = "senha4";               // senha do usuário 6

// Usuário 7
$email7 = "usuario5@teste.com";   // e-mail do usuário 7
$senha7 = "senha5";               // senha do usuário 7

// Recebendo os dados enviados pelo formulário
$email = $_POST["email"] ?? "";   // pega o e-mail enviado no POST
$senha = $_POST["senha"] ?? "";   // pega a senha enviada no POST

// Verificação simples para todos os usuários cadastrados
if (
    ($email === $email_correto && $senha === $senha_correta) ||   // usuário 1
    ($email === $email2 && $senha === $senha2) ||                 // usuário 2
    ($email === $email3 && $senha === $senha3) ||                 // usuário 3
    ($email === $email4 && $senha === $senha4) ||                 // usuário 4
    ($email === $email5 && $senha === $senha5) ||                 // usuário 5
    ($email === $email6 && $senha === $senha6) ||                 // usuário 6
    ($email === $email7 && $senha === $senha7)                    // usuário 7
) {

    // Se o e-mail e senha estiverem corretos, redireciona para a página de marcação
    header("Location: ../pagina_de_marcação_de_consultas/marcação.html");
    exit;

} else {

    // Se estiver errado, mostra alerta e volta para a página de login
    echo "
        <script>
            alert('E-mail ou senha incorretos!');
            window.location.href = 'login.html';
        </script>
    ";
    exit;
}
?>
