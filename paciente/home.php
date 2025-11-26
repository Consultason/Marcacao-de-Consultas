<?php
session_start();

// Verifica se o usuário está logado
if(!isset($_SESSION["usuario"])) {
    header("Location: ../login/login.html");
    exit;
}

// Nome do paciente (opcional)
$nomePaciente = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área do Paciente</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>

<header>
    <h1>Bem-vindo, <?php echo $nomePaciente; ?>!</h1>
</header>

<main>

    <div class="menu-box">
        <button onclick="marcarConsulta()">Marcar Consulta</button>
        <button onclick="verConsultas()">Ver Consultas Agendadas</button>
        <button onclick="editarCadastro()">Editar Cadastro</button>
        <button onclick="voltarInicio()">Voltar à Página Inicial</button>
        <button class="logout" onclick="logoff()">Sair</button>
    </div>

</main>

<script src="home.js"></script>
</body>
</html>
