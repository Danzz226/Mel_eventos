<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EventHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="d-flex">
    <form action="login_process.php" method="POST">
        <h2>🔐 Login - EventHub</h2>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>

        <label for="nome">Usuário:</label>
        <input type="text" name="nome" id="nome" placeholder="Digite seu usuário" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>

        <button type="submit">🚀 Entrar</button>
        
        <p style="text-align:center; margin-top:15px;">
            <a href="register.php" style="color: #007bff;">📝 Criar nova conta</a>
        </p>
    </form>
</body>
</html>

