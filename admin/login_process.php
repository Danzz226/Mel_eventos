<?php
session_start();

// Credenciais padrão de admin
$admin_usuario = 'admin';
$admin_senha = 'admin';

if (!empty($_POST['usuario']) && !empty($_POST['senha'])) {
    $usuario = trim($_POST['usuario']);
    $senha = $_POST['senha'];
    
    // Verificar credenciais
    if ($usuario === $admin_usuario && $senha === $admin_senha) {
        $_SESSION['admin_autenticado'] = true;
        header("Location: executivos.php");
        exit;
    } else {
        header("Location: login.php?error=Usuário ou senha incorretos");
        exit;
    }
} else {
    header("Location: login.php?error=Preencha todos os campos");
    exit;
}

