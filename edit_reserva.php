<?php
include "conexao.php";

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
    <title>Editar Reserva</title>
    <link rel="stylesheet" href="crud/style.css">
</head>
<body>
    <div class="top-bar">
        <h2>Editar Reserva</h2>
        <div>
            <a href="index.php" class="button">Voltar</a>
        </div>
    </div>

    <h1>Editar Reserva</h1>
    <form action="update_reserva.php" method="post">
        <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva'] ?>">

        <label for="id_salao">Salão</label>
        <select name="id_salao" required>
            <?php while($s = $saloes->fetch_assoc()): ?>
                <option value="<?= $s['id_salao'] ?>" <?= $s['id_salao'] == $reserva['id_salao'] ? "selected" : "" ?>>
                    <?= $s['nome'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="data_evento_inicio">Data Início</label>
        <input type="datetime-local" name="data_evento_inicio" value="<?= date('Y-m-d\TH:i', strtotime($reserva['data_evento_inicio'])) ?>" required>

        <label for="data_evento_fim">Data Fim</label>
        <input type="datetime-local" name="data_evento_fim" value="<?= $reserva['data_evento_fim'] ? date('Y-m-d\TH:i', strtotime($reserva['data_evento_fim'])) : '' ?>" required>

        <label for="numero_participantes_est">Número de Participantes</label>
        <input type="number" name="numero_participantes_est" value="<?= $reserva['numero_participantes_est'] ?>" required>

        <label for="observacoes">Observações</label>
        <textarea name="observacoes" rows="4"><?= $reserva['observacoes'] ?></textarea>

        <label for="total_previsto">Total Previsto (R$)</label>
        <input type="number" step="0.01" name="total_previsto" value="<?= $reserva['total_previsto'] ?>" readonly>

        <label for="status">Status</label>
        <select name="status" required>
            <option value="pendente" <?= $reserva['status'] == "pendente" ? "selected" : "" ?>>Pendente</option>
            <option value="confirmada" <?= $reserva['status'] == "confirmada" ? "selected" : "" ?>>Confirmada</option>
            <option value="cancelada" <?= $reserva['status'] == "cancelada" ? "selected" : "" ?>>Cancelada</option>
            <option value="concluida" <?= $reserva['status'] == "concluida" ? "selected" : "" ?>>Concluída</option>
        </select>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>