<?php
session_start();
include "../includes/conexao.php";

// Verifica se está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

$usuario_nome = $_SESSION['usuario_nome'];
$usuario_id = $_SESSION['usuario_id'];

// Verificar se está autenticado como admin
if (!isset($_SESSION['admin_autenticado']) || $_SESSION['admin_autenticado'] !== true) {
    header("Location: login.php?error=É necessário fazer login administrativo para acessar esta área.");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Executiva - EventHub</title>
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
                <li class="user-info">
                    <span>👤 <?= htmlspecialchars($usuario_nome) ?> (Admin)</span>
                    <a href="logout.php" class="btn-logout">Sair Admin</a>
                    <a href="../pages/logout.php" class="btn-logout" style="margin-left: 0.5rem;">Sair Sistema</a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            <h1 class="page-title">👔 Área Executiva</h1>
            <p style="text-align: center; color: #666; margin-bottom: 2rem;">Gerencie todas as reservas do sistema</p>
            
            <!-- Listagem de Reservas -->
            <section class="list-section">
                <h2>Todas as Reservas</h2>
                <div class="table-container">
                    <table class="table-reservas">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuário</th>
                                <th>Salão</th>
                                <th>Data Início</th>
                                <th>Data Fim</th>
                                <th>Participantes</th>
                                <th>Status</th>
                                <th>Total (R$)</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql = "SELECT 
                                        r.id_reserva,
                                        u.nome AS usuario_nome,
                                        s.nome AS salao_nome,
                                        r.data_evento_inicio,
                                        r.data_evento_fim,
                                        r.numero_participantes_est,
                                        r.status,
                                        r.total_previsto
                                    FROM Reserva r
                                    JOIN Salao s ON r.id_salao = s.id_salao
                                    JOIN usuario u ON r.id_usuario = u.id_usuario
                                    ORDER BY r.data_evento_inicio DESC";

                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "
                                    <tr>
                                        <td>".$row['id_reserva']."</td>
                                        <td>".htmlspecialchars($row['usuario_nome'])."</td>
                                        <td>".htmlspecialchars($row['salao_nome'])."</td>
                                        <td>".date("d/m/Y H:i", strtotime($row['data_evento_inicio']))."</td>
                                        <td>".($row['data_evento_fim'] ? date("d/m/Y H:i", strtotime($row['data_evento_fim'])) : '-')."</td>
                                        <td>".($row['numero_participantes_est'] ?? '-')."</td>
                                        <td><span class='status-badge status-".$row['status']."'>".htmlspecialchars($row['status'])."</span></td>
                                        <td>".number_format($row['total_previsto'], 2, ',', '.')."</td>
                                        <td style='min-width: 120px;'>
                                            <div style='display: flex; flex-direction: column; gap: 0.5rem;'>
                                                <a href='../crud_operations/edit_reserva.php?id=".$row['id_reserva']."' class='btn-action btn-edit' style='width: 100%; text-align: center;'>✏️ Editar</a>
                                                <a href='../crud_operations/delete_reserva.php?id=".$row['id_reserva']."' class='btn-action btn-delete' onclick='return confirm(\"Excluir esta reserva?\")' style='width: 100%; text-align: center;'>🗑️ Excluir</a>
                                            </div>
                                        </td>
                                    </tr>
                                    ";
                                }
                            } else {
                                echo "<tr><td colspan='9' class='no-data'>Nenhuma reserva foi cadastrada!</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Estatísticas -->
            <?php
            $total_reservas = $conn->query("SELECT COUNT(*) as total FROM Reserva")->fetch_assoc()['total'];
            $reservas_pendentes = $conn->query("SELECT COUNT(*) as total FROM Reserva WHERE status = 'pendente'")->fetch_assoc()['total'];
            $reservas_confirmadas = $conn->query("SELECT COUNT(*) as total FROM Reserva WHERE status = 'confirmada'")->fetch_assoc()['total'];
            $total_receita = $conn->query("SELECT SUM(total_previsto) as total FROM Reserva WHERE status IN ('confirmada', 'concluida')")->fetch_assoc()['total'] ?? 0;
            ?>
            <section class="form-section" style="margin-top: 2rem;">
                <h2>📊 Estatísticas</h2>
                <div class="services-grid" style="margin-top: 1rem;">
                    <div class="service-card">
                        <div class="service-icon">📋</div>
                        <h3>Total de Reservas</h3>
                        <p style="font-size: 2rem; font-weight: bold; color: var(--secondary-color);"><?= $total_reservas ?></p>
                    </div>
                    <div class="service-card">
                        <div class="service-icon">⏳</div>
                        <h3>Pendentes</h3>
                        <p style="font-size: 2rem; font-weight: bold; color: #ffc107;"><?= $reservas_pendentes ?></p>
                    </div>
                    <div class="service-card">
                        <div class="service-icon">✅</div>
                        <h3>Confirmadas</h3>
                        <p style="font-size: 2rem; font-weight: bold; color: #28a745;"><?= $reservas_confirmadas ?></p>
                    </div>
                    <div class="service-card">
                        <div class="service-icon">💰</div>
                        <h3>Receita Total</h3>
                        <p style="font-size: 1.5rem; font-weight: bold; color: var(--secondary-color);">R$ <?= number_format($total_receita, 2, ',', '.') ?></p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script src="../assets/js/reservas.js"></script>
</body>
</html>

