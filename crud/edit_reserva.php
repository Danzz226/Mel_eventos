<?php
session_start();
include "../connection.php";

// Protege a página (apenas usuários logados)
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

// Verifica se o ID foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("⚠️ ID da reserva não informado.");
}

$id_reserva = intval($_GET['id']);
$id_usuario = $_SESSION['usuario_id'];

// Busca a reserva do usuário logado
$sql = "SELECT r.*, s.nome AS salao_nome
        FROM Reserva r
        JOIN Salao s ON r.id_salao = s.id_salao
        WHERE r.id_reserva = ? AND r.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_reserva, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("⚠️ Reserva não encontrada ou não pertence a este usuário.");
}

$reserva = $result->fetch_assoc();

// Buscar lista de salões
$saloes = $conn->query("SELECT id_salao, nome FROM Salao ORDER BY nome ASC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Reserva</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        form { max-width: 600px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        button { margin-top: 15px; padding: 10px 15px; background: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .logout { background: #dc3545; padding: 8px 12px; border-radius: 5px; color: white; text-decoration: none; }
        .logout:hover { background: #b02a37; }
    </style>
</head>
<body>
    <div class="top-bar">
        <h2>Editar Reserva</h2>
        <div>
            👤 <?= htmlspecialchars($_SESSION['usuario_nome']) ?> |
            <a href="../logout.php" class="logout">Sair</a>
        </div>
    </div>

    <form action="update_reserva.php" method="POST" id="formEditar">
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
        <input type="datetime-local" name="data_evento_inicio"
            value="<?= date('Y-m-d\TH:i', strtotime($reserva['data_evento_inicio'])) ?>" required>

        <label for="data_evento_fim">Data Fim</label>
        <input type="datetime-local" name="data_evento_fim"
            value="<?= $reserva['data_evento_fim'] ? date('Y-m-d\TH:i', strtotime($reserva['data_evento_fim'])) : '' ?>" required>

        <label for="numero_participantes_est">Número de Participantes</label>
        <input type="number" name="numero_participantes_est" id="numero_participantes_est"
            value="<?= $reserva['numero_participantes_est'] ?>" required>

        <label for="observacoes">Observações</label>
        <textarea name="observacoes" rows="4"><?= $reserva['observacoes'] ?></textarea>

        <label for="total_previsto">Total Previsto (R$)</label>
        <input type="number" step="0.01" name="total_previsto" id="total_previsto"
            value="<?= $reserva['total_previsto'] ?>" readonly>

        <label for="status">Status</label>
        <select name="status" required>
            <option value="pendente" <?= $reserva['status'] == "pendente" ? "selected" : "" ?>>Pendente</option>
            <option value="confirmada" <?= $reserva['status'] == "confirmada" ? "selected" : "" ?>>Confirmada</option>
            <option value="cancelada" <?= $reserva['status'] == "cancelada" ? "selected" : "" ?>>Cancelada</option>
            <option value="concluida" <?= $reserva['status'] == "concluida" ? "selected" : "" ?>>Concluída</option>
        </select>

        <button type="submit">Salvar Alterações</button>
    </form>

    <script>
        const form = document.getElementById("formEditar");

        function recalcularTotal() {
            const participantes = parseInt(document.getElementById("numero_participantes_est").value) || 0;
            const inicio = new Date(document.querySelector('[name="data_evento_inicio"]').value);
            const fim = new Date(document.querySelector('[name="data_evento_fim"]').value);

            let dias = 1;
            if (!isNaN(inicio) && !isNaN(fim) && fim > inicio) {
                const diff = Math.ceil((fim - inicio) / (1000 * 60 * 60 * 24));
                dias = diff > 0 ? diff + 1 : 1;
            }

            let total = (2000 * dias) + (participantes * 10);
            document.getElementById("total_previsto").value = total.toFixed(2);
        }

        form.addEventListener("input", recalcularTotal);
    </script>
</body>
</html>
