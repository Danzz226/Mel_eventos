<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: crud/list_reservas.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
        }
        form {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 320px;
        }
        h2 { text-align: center; color: #333; }
        input {
            width: 100%; padding: 10px; margin: 10px 0;
            border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            width: 100%; padding: 10px;
            background-color: #28a745; border: none;
            color: #fff; font-weight: bold; border-radius: 5px;
            cursor: pointer;
        }
        button:hover { background-color: #218838; }
        p.error { color: red; text-align: center; }
        p.success { color: green; text-align: center; }
        .link { text-align: center; margin-top: 10px; }
        .link a { color: #007bff; text-decoration: none; }
        .link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <form action="register_process.php" method="POST">
        <h2>Criar Conta</h2>

        <?php if (isset($_GET['msg'])): ?>
            <p class="<?= strpos($_GET['msg'], 'sucesso') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($_GET['msg']) ?>
            </p>
        <?php endif; ?>

        <input type="text" name="nome" placeholder="Nome de usuário" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <input type="password" name="confirmar_senha" placeholder="Confirmar senha" required>
        <button type="submit">Cadastrar</button>

        <div class="link">
            <a href="login.php">Já tem conta? Faça login</a>
        </div>
    </form>
</body>
</html>
