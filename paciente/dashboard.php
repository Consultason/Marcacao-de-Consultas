<?php
session_start();

// Se não existir sessão, volta para o login
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login/login.html");
    exit;
}

// Se estiver tudo ok, carrega o HTML
readfile("dashboard.html");
?>
