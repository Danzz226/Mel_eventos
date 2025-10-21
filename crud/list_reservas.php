<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

$sql = "SELECT 
            r.id_reserva,
            s.nome AS salao_nome,
            r.data_evento_inicio,
            r.status,
            r.total_previsto
        FROM Reserva r
        JOIN Salao s ON r.id_salao = s.id_salao
        WHERE r.id_usuario = $id_usuario
        ORDER BY r.data_evento_inicio DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Reservas</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #007bff; color: white; }
        a.button { padding: 6px 10px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; }
        a.edit { background: #ffc107; }
        a.delete { background: #dc3545; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; }
        .logout { background: #dc3545; color: white; padding: 6px 10px; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="top-bar">
        <h2>Minhas Reservas</h2>
        <div>
            👤 <?= htmlspecialchars($_SESSION['usuario_nome']) ?> |
            <a href="../logout.php" class="logout">Sair</a>
        </div>
    </div>

    <a href="nova_reserva.php" class="button">➕ Nova Reserva</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Salão</th>
            <th>Data Início</th>
            <th>Status</th>
            <th>Total (R$)</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_reserva'] ?></td>
            <td><?= htmlspecialchars($row['salao_nome']) ?></td>
            <td><?= date("d/m/Y H:i", strtotime($row['data_evento_inicio'])) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= number_format($row['total_previsto'], 2, ',', '.') ?></td>
            <td>
                <a href="edit_reserva.php?id=<?= $row['id_reserva'] ?>" class="button edit">✏️ Editar</a>
                <a href="delete_reserva.php?id=<?= $row['id_reserva'] ?>" class="button delete" onclick="return confirm('Excluir esta reserva?')">🗑️ Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
