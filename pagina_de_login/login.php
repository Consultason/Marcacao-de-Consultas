<?php
// Conexão com o banco
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "BemNordeste";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Recebe email e senha do formulário
$email = $_POST["email"] ?? "";
$senhaDigitada = $_POST["senha"] ?? "";

// Consulta o usuário no banco
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se encontrou o usuário
if ($result->num_rows === 1) {

    $usuario = $result->fetch_assoc();

    // Comparação simples da senha
    if ($senhaDigitada === $usuario["senha"]) {

        // PEGAMOS O ID DO USUÁRIO DO BANCO
        $user_id = $usuario["id"];

        // 🔹 INICIAMOS A SESSÃO
        session_start();
        
        // 🔹 SALVAMOS O ID DO USUÁRIO NA SESSÃO
        $_SESSION['user_id'] = $user_id;

        // 🔹 REDIRECIONA PARA A ÁREA DO PACIENTE
        header("Location: ../paciente/dashboard.html");
        exit;

    } else {
        echo "
        <script>
            alert('Senha incorreta!');
            window.location.href = 'login.html';
        </script>";
        exit;
    }

} else {
    echo "
    <script>
        alert('Usuário não encontrado no banco de dados!');
        window.location.href = 'login.html';
    </script>";
    exit;
}
?>
