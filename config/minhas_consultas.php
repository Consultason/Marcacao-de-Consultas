<?php
require 'conexao.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id, especialidade, data_consulta, hora_consulta, observacoes FROM consultas WHERE user_id = ? ORDER BY data_consulta, hora_consulta");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Minhas Consultas</title></head>
<body>
<h1>Minhas Consultas</h1>

<p><a href="form_criar_consulta.html">Marcar nova consulta</a> | <a href="area_paciente.php">Voltar à área do paciente</a></p>

<?php if ($res->num_rows === 0): ?>
    <p>Nenhuma consulta agendada.</p>
<?php else: ?>
    <table border="1" cellpadding="6" cellspacing="0">
      <tr><th>Especialidade</th><th>Data</th><th>Hora</th><th>Observações</th><th>Ações</th></tr>
      <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
          <td><?= e($row['especialidade']) ?></td>
          <td><?= e($row['data_consulta']) ?></td>
          <td><?= e($row['hora_consulta']) ?></td>
          <td><?= e($row['observacoes']) ?></td>
          <td>
            <a href="editar_consulta.php?id=<?= $row['id'] ?>">Editar</a> |
            <form action="deletar_consulta.php" method="post" style="display:inline" onsubmit="return confirm('Confirmar exclusão?');">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button type="submit">Excluir</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
<?php endif; ?>

</body>
</html>
<?php $stmt->close(); ?>
