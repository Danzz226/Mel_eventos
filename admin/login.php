<?php
session_start();

// Verifica se está logado como usuário
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

// Se já está autenticado como admin, redireciona
if (isset($_SESSION['admin_autenticado']) && $_SESSION['admin_autenticado'] === true) {
    header("Location: executivos.php");
    exit;
}

// Verifica se tem mensagem de erro
$erro = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - EventHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="d-flex">
    <form action="login_process.php" method="POST" style="max-width: 400px;">
        <h2>🔐 Login Administrativo</h2>
        <?php if ($erro): ?>
            <p class="error"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <label for="usuario">Usuário Administrador:</label>
        <input type="text" name="usuario" id="usuario" placeholder="Digite o usuário" required autocomplete="off">

        <label for="senha">Senha Administrativa:</label>
        <input type="password" name="senha" id="senha" placeholder="Digite a senha" required>

        <button type="submit">🚀 Entrar</button>
        
        <p style="text-align:center; margin-top:15px;">
            <a href="../crud_operations/gerenciar_eventos.php" style="color: var(--primary-color);">← Voltar</a>
        </p>
    </form>
</body>
</html>

