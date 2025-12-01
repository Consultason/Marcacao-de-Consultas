<?php
require 'conexao.php';

// 1) Verifica se usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); exit;
}
$user_id = $_SESSION['user_id'];

// 2) Recebe dados do POST
$especialidade = trim($_POST['especialidade'] ?? '');
$data_consulta = $_POST['data_consulta'] ?? '';
$hora_consulta = $_POST['hora_consulta'] ?? '';
$observacoes = trim($_POST['observacoes'] ?? '');

// 3) Validações básicas
$errors = [];
if ($especialidade === '') $errors[] = 'Especialidade é obrigatória.';
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_consulta)) $errors[] = 'Data inválida.';
if (!preg_match('/^\d{2}:\d{2}$/', $hora_consulta)) $errors[] = 'Hora inválida.';

// Evita datas no passado
if (empty($errors)) {
    $hoje = date('Y-m-d');
    if ($data_consulta < $hoje) $errors[] = 'Não é possível agendar em data passada.';
}

if (!empty($errors)) {
    foreach ($errors as $err) {
        echo '<p>' . e($err) . '</p>';
    }
    echo '<p><a href="form_criar_consulta.html">Voltar</a></p>';
    exit;
}

// 4) prevenir horários duplicados para o mesmo usuário
$stmt = $conn->prepare("SELECT COUNT(*) AS c FROM consultas WHERE user_id = ? AND data_consulta = ? AND hora_consulta = ?");
$stmt->bind_param("iss", $user_id, $data_consulta, $hora_consulta);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();
if ($row['c'] > 0) {
    echo '<p>Você já tem uma consulta nesse dia/horário.</p><p><a href="form_criar_consulta.html">Voltar</a></p>';
    exit;
}

// 5) Insere com prepared statement
$ins = $conn->prepare("INSERT INTO consultas (user_id, especialidade, data_consulta, hora_consulta, observacoes) VALUES (?, ?, ?, ?, ?)");
$ins->bind_param("issss", $user_id, $especialidade, $data_consulta, $hora_consulta, $observacoes);
if ($ins->execute()) {
    header('Location: minhas_consultas.php?msg=criado');
    exit;
} else {
    echo "Erro: " . e($ins->error);
}
$ins->close();
?>
