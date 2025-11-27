<?php
require 'conexao.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$user_id = $_SESSION['user_id'];

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) { echo "ID inválido"; exit; }

// Verifica propriedade
$stmt = $conn->prepare("SELECT user_id FROM consultas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) { echo "Consulta não encontrada"; exit; }
$row = $res->fetch_assoc();
$stmt->close();
if ($row['user_id'] != $user_id) { echo "Acesso negado"; exit; }

// Apaga
$del = $conn->prepare("DELETE FROM consultas WHERE id = ?");
$del->bind_param("i", $id);
if ($del->execute()) {
    header('Location: minhas_consultas.php?msg=deletado');
    exit;
} else {
    echo "Erro: " . e($del->error);
}
$del->close();
?>
