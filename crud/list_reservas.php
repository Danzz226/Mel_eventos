<?php
session_start();
include "../connection.php";

// Impede acesso sem login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

// Consulta reservas com o nome do usuário e do salão
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
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover { background-color: #f1f1f1; }
        a.button {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-add { background-color: #28a745; }
        .btn-edit { background-color: #007bff; }
        .btn-del { background-color: #dc3545; }
        .btn-logout { background-color: #6c757d; float: right; }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .usuario-logado {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h2>Reservas Cadastradas</h2>
        <div>
            <span class="usuario-logado">👤 <?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>
            <a href="../logout.php" class="button btn-logout">Sair</a>
        </div>
    </div>

    <a href="nova_reserva.php" class="button btn-add">+ Nova Reserva</a>

    <?php if ($result->num_rows > 0): ?>
        <table>
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
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_reserva'] ?></td>
                    <td><?= htmlspecialchars($row['usuario_nome']) ?></td>
                    <td><?= htmlspecialchars($row['salao_nome']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['data_evento_inicio'])) ?></td>
                    <td><?= $row['data_evento_fim'] ? date('d/m/Y H:i', strtotime($row['data_evento_fim'])) : '-' ?></td>
                    <td><?= $row['numero_participantes_est'] ?></td>
                    <td><?= ucfirst($row['status']) ?></td>
                    <td><?= number_format($row['total_previsto'], 2, ',', '.') ?></td>
                    <td>
                        <a href="edit_reserva.php?id=<?= $row['id_reserva'] ?>" class="button btn-edit">Editar</a>
                        <a href="delete_reserva.php?id=<?= $row['id_reserva'] ?>"
                        onclick="return confirm('Tem certeza que deseja excluir esta reserva?');"
                        class="button btn-del">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center; margin-top:20px;">Nenhuma reserva cadastrada.</p>
    <?php endif; ?>
</body>
</html>
