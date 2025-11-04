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
    <title>Cadastro Profissional - Mel Eventos</title>
    <link rel="stylesheet" href="crud/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="d-flex">
    <form action="register_process.php" method="POST">
        <h2>📝 Criar Conta Profissional</h2>

        <?php if (isset($_GET['msg'])): ?>
            <p class="<?= strpos($_GET['msg'], 'sucesso') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($_GET['msg']) ?>
            </p>
        <?php endif; ?>

        <label for="nome">👤 Nome de usuário:</label>
        <input type="text" name="nome" id="nome" placeholder="Digite seu nome de usuário" required>

        <label for="senha">🔒 Senha:</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>

        <label for="confirmar_senha">🔒 Confirmar senha:</label>
        <input type="password" name="confirmar_senha" id="confirmar_senha" placeholder="Digite a senha novamente" required>

        <button type="submit">✅ Cadastrar</button>

        <p style="text-align:center; margin-top:1.5rem;">
            <a href="login_profissional.php" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">🔐 Já tem conta? Faça login</a>
        </p>
    </form>
</body>
</html>

