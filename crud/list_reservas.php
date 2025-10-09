<?php
include "../connection.php";

$sql = "SELECT r.id_reserva, r.data_evento_inicio, r.data_evento_fim,
               r.numero_participantes_est, r.total_previsto, r.status,
               u.nome AS usuario_nome, u.email AS usuario_email,
               s.nome AS salao_nome
        FROM Reserva r
        JOIN Usuario u ON r.id_usuario = u.id_usuario
        JOIN Salao s ON r.id_salao = s.id_salao
        ORDER BY r.data_evento_inicio DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Reservas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 5px; font-size: 14px; }
        .btn-edit { background: #007bff; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-new { background: #28a745; color: white; margin-bottom: 10px; display: inline-block; }
        .status-pendente { background-color: #ffc107; color: #000; padding: 3px 6px; border-radius: 4px; }
        .status-confirmada { background-color: #28a745; color: #fff; padding: 3px 6px; border-radius: 4px; }
        .status-cancelada { background-color: #dc3545; color: #fff; padding: 3px 6px; border-radius: 4px; }
        .status-concluida { background-color: #6c757d; color: #fff; padding: 3px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <h2>Lista de Reservas</h2>
    <a href="nova_reserva.php" class="btn btn-new">+ Nova Reserva</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Email</th>
            <th>Salão</th>
            <th>Data Início</th>
            <th>Data Fim</th>
            <th>Participantes</th>
            <th>Total (R$)</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_reserva'] ?></td>
                    <td><?= $row['usuario_nome'] ?></td>
                    <td><?= $row['usuario_email'] ?></td>
                    <td><?= $row['salao_nome'] ?></td>
                    <td><?= date("d/m/Y H:i", strtotime($row['data_evento_inicio'])) ?></td>
                    <td><?= $row['data_evento_fim'] ? date("d/m/Y H:i", strtotime($row['data_evento_fim'])) : "-" ?></td>
                    <td><?= $row['numero_participantes_est'] ?></td>
                    <td><?= number_format($row['total_previsto'], 2, ',', '.') ?></td>
                    <td>
                        <span class="status-<?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span>
                    </td>
                    <td>
                        <a href="edit_reserva.php?id=<?= $row['id_reserva'] ?>" class="btn btn-edit">Editar</a>
                        <a href="delete_reserva.php?id=<?= $row['id_reserva'] ?>" class="btn btn-delete" onclick="return confirm('Tem certeza que deseja excluir esta reserva?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="10">Nenhuma reserva cadastrada.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
