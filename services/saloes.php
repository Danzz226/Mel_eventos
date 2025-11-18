<?php
session_start();
include "../includes/conexao.php";

// Verifica se está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

$usuario_nome = $_SESSION['usuario_nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva de Salões - EventHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <h1>🎉 EventHub</h1>
            </div>
            <ul class="nav-menu">
                <li><a href="../pages/home.php" class="nav-link">Voltar ao Início</a></li>
                <li><a href="../crud_operations/gerenciar_eventos.php" class="nav-link">Gerenciar Eventos</a></li>
                <?php if (isset($_SESSION['admin_autenticado']) && $_SESSION['admin_autenticado'] === true): ?>
                    <li><a href="../admin/executivos.php" class="nav-link" style="color: var(--primary-color); font-weight: 600;">👔 Minha Área</a></li>
                <?php else: ?>
                    <li><a href="../admin/login.php" class="nav-link" style="color: var(--primary-color); font-weight: 600;">🔐 Login Admin</a></li>
                <?php endif; ?>
                <li class="user-info">
                    <span>👤 <?= htmlspecialchars($usuario_nome) ?></span>
                    <a href="../pages/logout.php" class="btn-logout">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            <div class="form-section" style="text-align: center;">
                <h1 class="page-title">🏛️ Reserva de Salões</h1>
                <p style="font-size: 1.2rem; color: var(--secondary-color); margin: 2rem 0;">
                    Escolha entre diversos salões disponíveis, com diferentes capacidades e ambientes para o seu evento.
                </p>
                
                <div style="margin: 3rem 0;">
                    <a href="../crud_operations/gerenciar_eventos.php" class="btn-primary" style="padding: 1.5rem 3rem; font-size: 1.2rem; display: inline-block;">
                        Criar Nova Reserva
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

