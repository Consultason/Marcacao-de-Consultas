<?php
require 'conexao.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) { echo "ID inválido"; exit; }

    // Busca e verifica propriedade
    $stmt = $conn->prepare("SELECT id, especialidade, data_consulta, hora_consulta, observacoes, user_id FROM consultas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) { echo "Consulta não encontrada"; exit; }
    $row = $res->fetch_assoc();
    $stmt->close();

    if ($row['user_id'] != $user_id) { echo "Acesso negado"; exit; }

    // Mostrar formulário preenchido
    ?>
    <!doctype html>
    <html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Editar Consulta</title>

        <!-- Importa o arquivo CSS externo responsável pelo estilo da página -->
  <link rel="stylesheet" href="marcar_consulta.css">
    </head>
    <body>

    <main>
<!-- Container do formulário -->
    <section class="container">

<div class="logo">

        <!-- Imagem da logo da clínica -->
        <img src="logotipo.png" alt="Logo da Clínica Bem Nordeste">
</div>

    <h1>Editar Consulta</h1>

    <div class="form-group">

    <form method="post" action="editar_consulta.php">
      <input type="hidden" name="id" value="<?= e($row['id']) ?>">
      <label>Especialidade:<br><input name="especialidade" value="<?= e($row['especialidade']) ?>" required></label><br><br>
      <label>Data:<br><input type="date" name="data_consulta" value="<?= e($row['data_consulta']) ?>" required></label><br><br>
      <label>Hora:<br><input type="time" name="hora_consulta" value="<?= e($row['hora_consulta']) ?>" required></label><br><br>
      <label>Observações:<br><textarea name="observacoes" rows="4" cols="40"><?= e($row['observacoes']) ?></textarea></label><br><br>
      <button type="submit">Salvar</button>
    </form>
    <p><a href="minhas_consultas.php">Voltar</a></p>
    </main>
</body>
</html>
    <?php
    exit;
}

// POST - processa atualização
$id = intval($_POST['id'] ?? 0);
$especialidade = trim($_POST['especialidade'] ?? '');
$data_consulta = $_POST['data_consulta'] ?? '';
$hora_consulta = $_POST['hora_consulta'] ?? '';
$observacoes = trim($_POST['observacoes'] ?? '');

// Valida
if ($id <= 0) { echo "ID inválido"; exit; }
$errors = [];
if ($especialidade === '') $errors[] = 'Especialidade obrigatória';
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_consulta)) $errors[] = 'Data inválida';
if (!preg_match('/^\d{2}:\d{2}$/', $hora_consulta)) $errors[] = 'Hora inválida';
if (!empty($errors)) {
    foreach ($errors as $err) echo '<p>' . e($err) . '</p>';
    echo '<p><a href="minhas_consultas.php">Voltar</a></p>';
    exit;
}

// Verifica que a consulta pertence ao usuário
$check = $conn->prepare("SELECT user_id FROM consultas WHERE id = ?");
$check->bind_param("i", $id);
$check->execute();
$res = $check->get_result();
if ($res->num_rows === 0) { echo "Consulta não encontrada"; exit; }
$row = $res->fetch_assoc();
$check->close();
if ($row['user_id'] != $user_id) { echo "Acesso negado"; exit; }

// Atualiza
$up = $conn->prepare("UPDATE consultas SET especialidade = ?, data_consulta = ?, hora_consulta = ?, observacoes = ? WHERE id = ?");
$up->bind_param("ssssi", $especialidade, $data_consulta, $hora_consulta, $observacoes, $id);
if ($up->execute()) {
    header('Location: minhas_consultas.php?msg=editado');
    exit;
} else {
    echo "Erro: " . e($up->error);
}
$up->close();
?>
