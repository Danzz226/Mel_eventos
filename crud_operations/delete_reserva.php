<?php
session_start();
include "../includes/conexao.php";
include "../classes/ReservaManager.php";

// Verifica se está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

$reservaManager = new ReservaManager($conn);

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: gerenciar_eventos.php?erro=ID não fornecido");
    exit;
}

$resultado = $reservaManager->excluirReserva($id);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $resultado['sucesso'] ? 'Sucesso' : 'Erro' ?> - EventHub</title>
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
                
                <li><a href="gerenciar_eventos.php" class="nav-link">Gerenciar Eventos</a></li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            <div class="form-section" style="text-align: center; padding: 3rem;">
                <?php if ($resultado['sucesso']): ?>
                    <div style="font-size: 4rem; margin-bottom: 1rem;">✅</div>
                    <h2 style="color: #28a745; margin-bottom: 1rem;">Reserva Excluída com Sucesso!</h2>
                    <p style="font-size: 1.1rem; margin-bottom: 2rem;"><?= htmlspecialchars($resultado['mensagem']) ?></p>
                <?php else: ?>
                    <div style="font-size: 4rem; margin-bottom: 1rem;">❌</div>
                    <h2 style="color: #dc3545; margin-bottom: 1rem;">Erro ao Excluir Reserva</h2>
                    <p style="font-size: 1.1rem; margin-bottom: 2rem;"><?= htmlspecialchars($resultado['mensagem']) ?></p>
                <?php endif; ?>
                
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <?php if (isset($_SESSION['admin_autenticado']) && $_SESSION['admin_autenticado'] === true): ?>
                        <a href="../admin/executivos.php" class="btn-primary">👔 Voltar para Área Executiva</a>
                    <?php endif; ?>
                    <a href="gerenciar_eventos.php" class="btn-primary">Gerenciar Eventos</a>
                    <a href="../pages/home.php" class="btn-primary" style="background-color: var(--secondary-color); color: var(--text-light);">Voltar ao Início</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

