<?php
session_start();
include "../includes/conexao.php";

// Verifica se está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

$id = $_GET['id'];

$sql = "SELECT r.*, s.nome AS salao_nome FROM Reserva r JOIN Salao s ON r.id_salao = s.id_salao WHERE r.id_reserva = $id";
$result = $conn->query($sql);
$reserva = $result->fetch_assoc();

$saloes = $conn->query("SELECT id_salao, nome FROM Salao ORDER BY nome ASC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva - EventHub</title>
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
            <h1 class="page-title">Editar Reserva</h1>
            
            <section class="form-section">
                <form action="update_reserva.php" method="post" id="formReserva" class="form-reserva">
                    <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva'] ?>">

                    <div class="form-group">
                        <label for="id_salao">Salão</label>
                        <select name="id_salao" id="id_salao" required>
                            <?php while($s = $saloes->fetch_assoc()): ?>
                                <option value="<?= $s['id_salao'] ?>" <?= $s['id_salao'] == $reserva['id_salao'] ? "selected" : "" ?>>
                                    <?= $s['nome'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="data_evento_inicio">Data Início</label>
                        <input type="datetime-local" name="data_evento_inicio" id="data_evento_inicio" value="<?= date('Y-m-d\TH:i', strtotime($reserva['data_evento_inicio'])) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="data_evento_fim">Data Fim</label>
                        <input type="datetime-local" name="data_evento_fim" id="data_evento_fim" value="<?= $reserva['data_evento_fim'] ? date('Y-m-d\TH:i', strtotime($reserva['data_evento_fim'])) : '' ?>" required>
                        <div id="erroData" class="error-message" style="display:none;">⚠ A data de fim não pode ser menor que a de início!</div>
                    </div>

                    <div class="form-group">
                        <label for="numero_participantes_est">Número de Participantes</label>
                        <input type="number" name="numero_participantes_est" id="numero_participantes_est" value="<?= $reserva['numero_participantes_est'] ?>" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="observacoes">Observações</label>
                        <textarea name="observacoes" id="observacoes" rows="4"><?= htmlspecialchars($reserva['observacoes'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="total_previsto">Total Previsto (R$)</label>
                        <input type="number" step="0.01" name="total_previsto" id="total_previsto" value="<?= $reserva['total_previsto'] ?>" readonly>
                        <small style="color: #666; font-size: 0.9rem;">O valor é calculado automaticamente com base nas informações da reserva.</small>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" required>
                            <option value="pendente" <?= $reserva['status'] == "pendente" ? "selected" : "" ?>>Pendente</option>
                            <option value="confirmada" <?= $reserva['status'] == "confirmada" ? "selected" : "" ?>>Confirmada</option>
                            <option value="cancelada" <?= $reserva['status'] == "cancelada" ? "selected" : "" ?>>Cancelada</option>
                            <option value="concluida" <?= $reserva['status'] == "concluida" ? "selected" : "" ?>>Concluída</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit">Salvar Alterações</button>
                </form>
            </section>
        </div>
    </main>

    <script src="../assets/js/reservas.js"></script>
</body>
</html>