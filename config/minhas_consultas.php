<?php 
require 'conexao.php'; // Arquivo de conexão com o banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) { 
    header('Location: login.php'); 
    exit; 
}

$user_id = $_SESSION['user_id']; // ID do usuário logado

// Prepara consulta das consultas do usuário
$stmt = $conn->prepare("SELECT id, especialidade, data_consulta, hora_consulta, observacoes 
                        FROM consultas 
                        WHERE user_id = ? 
                        ORDER BY data_consulta, hora_consulta");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result(); // Obtém resultados
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Minhas Consultas</title>

    <!-- Arquivo CSS da página -->
    <link rel="stylesheet" href="marcar_consulta.css">
</head>
<body>


<main>
    <section class="container"> <!-- Caixa branca principal -->

        <!-- LOGO AGORA ESTÁ DENTRO DO CONTAINER -->
        <div class="logo" style="text-align:center; margin-bottom: 20px;">
            <img src="logotipo.png" alt="Logo da Clínica Bem Nordeste" style="width:300px;">
        </div>

        <!-- Links de navegação -->
        <p style="text-align:center;">
            <a href="form_criar_consulta.html">Marcar nova consulta</a> |
            <a href="../paciente/dashboard.html">Voltar à área do paciente</a>
        </p>

        <!-- Caso não existam consultas -->
        <?php if ($res->num_rows === 0): ?>
            <p style="text-align:center; font-weight:bold;">Nenhuma consulta agendada.</p>

        <!-- Caso exista pelo menos uma -->
        <?php else: ?>
            <table border="1" cellpadding="6" cellspacing="0" style="width:100%; margin-top:20px;">
                <tr>
                    <th>Especialidade</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Observações</th>
                    <th>Ações</th>
                </tr>

                <!-- Loop para exibir as consultas -->
                <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= e($row['especialidade']) ?></td>
                    <td><?= e($row['data_consulta']) ?></td>
                    <td><?= e($row['hora_consulta']) ?></td>
                    <td><?= e($row['observacoes']) ?></td>

                    <td>
                        <!-- Botão editar -->
                        <a href="editar_consulta.php?id=<?= $row['id'] ?>">Editar</a> |
                        
                        <!-- Formulário de deletar -->
                        <form action="deletar_consulta.php" method="post" 
                              style="display:inline" 
                              onsubmit="return confirm('Confirmar exclusão?');">
                              
                            <!-- Envia o ID da consulta -->
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">

                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>

            </table>
        <?php endif; ?>

    </section>
</main>

<footer>
    <p>&copy; Clínica BemNordeste</p>
</footer>

</body>
</html>

<?php 
$stmt->close(); // Encerra o statement
?>
