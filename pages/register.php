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
    <title>Cadastro - EventHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="d-flex">
    <form action="register_process.php" method="POST">
        <h2>📝 Criar Conta - EventHub</h2>

        <?php if (isset($_GET['msg'])): ?>
            <p class="<?= strpos($_GET['msg'], 'sucesso') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($_GET['msg']) ?>
            </p>
        <?php endif; ?>

        <label for="nome">Nome de usuário:</label>
        <input type="text" name="nome" id="nome" placeholder="Digite seu nome de usuário" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>

        <label for="confirmar_senha">Confirmar senha:</label>
        <input type="password" name="confirmar_senha" id="confirmar_senha" placeholder="Digite a senha novamente" required>

        <button type="submit">✅ Cadastrar</button>

        <p style="text-align:center; margin-top:15px;">
            <a href="login.php" style="color: #007bff;">🔐 Já tem conta? Faça login</a>
        </p>
    </form>
</body>
</html>

