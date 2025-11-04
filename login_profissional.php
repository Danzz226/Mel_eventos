<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Profissional - Mel Eventos</title>
    <link rel="stylesheet" href="crud/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="d-flex">
    <form action="login_process.php" method="POST">
        <h2>🔐 Login Profissional</h2>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>

        <label for="nome">👤 Usuário:</label>
        <input type="text" name="nome" id="nome" placeholder="Digite seu usuário" required>

        <label for="senha">🔒 Senha:</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>

        <button type="submit">🚀 Entrar</button>
        
        <p style="text-align:center; margin-top:1.5rem;">
            <a href="register_profissional.php" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">📝 Criar nova conta</a>
        </p>
    </form>
</body>
</html>

