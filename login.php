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
    <title>Login - Gerenciador de Eventos</title>
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
            width: 300px;
        }
        h2 { text-align: center; color: #333; }
        input {
            width: 100%; padding: 10px; margin: 10px 0;
            border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            width: 100%; padding: 10px;
            background-color: #007bff; border: none;
            color: #fff; font-weight: bold; border-radius: 5px;
            cursor: pointer;
        }
        button:hover { background-color: #0056b3; }
        p { text-align: center; color: red; }
    </style>
</head>
<body>
    <form action="login_process.php" method="POST">
        <h2>Login</h2>
        <?php if (isset($_GET['error'])): ?>
            <p><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>

        <input type="text" name="nome" placeholder="Usuário" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
        <p style="text-align:center; margin-top:10px;">
            <a href="register.php">Criar conta</a>
        </p>
    </form>
</body>
</html>
