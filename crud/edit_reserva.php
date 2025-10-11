<?php
include "../connection.php";

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("⚠️ ID da reserva não informado.");
}

$id_reserva = $_GET['id'];

$sql = "SELECT r.*, u.nome AS usuario_nome, u.email AS usuario_email, s.nome AS salao_nome
        FROM Reserva r
        JOIN Usuario u ON r.id_usuario = u.id_usuario
        JOIN Salao s ON r.id_salao = s.id_salao
        WHERE r.id_reserva = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_reserva);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("⚠️ Reserva não encontrada.");
}

$reserva = $result->fetch_assoc();

$saloes = $conn->query("SELECT id_salao, nome FROM Salao ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Reserva</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 600px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        input[readonly] { background-color: #f9f9f9; color: #555; cursor: not-allowed; }
        button { margin-top: 15px; padding: 10px 15px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .total { font-size: 18px; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>
    <h2>Editar Reserva</h2>
    <form action="update_reserva.php" method="POST" id="formReserva">
        <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva'] ?>">

        <label>Nome do Usuário</label>
        <input type="text" value="<?= htmlspecialchars($reserva['usuario_nome']) ?>" readonly>

        <label>Email do Usuário</label>
        <input type="email" value="<?= htmlspecialchars($reserva['usuario_email']) ?>" readonly>

        <label for="id_salao">Salão</label>
        <select name="id_salao" id="id_salao" required>
            <?php while($s = $saloes->fetch_assoc()): ?>
                <option value="<?= $s['id_salao'] ?>" <?= $s['id_salao'] == $reserva['id_salao'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($s['nome']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="data_evento_inicio">Data Início</label>
        <input type="datetime-local" name="data_evento_inicio" id="data_evento_inicio"
            value="<?= date('Y-m-d\TH:i', strtotime($reserva['data_evento_inicio'])) ?>" required>

        <label for="data_evento_fim">Data Fim</label>
        <input type="datetime-local" name="data_evento_fim" id="data_evento_fim"
            value="<?= $reserva['data_evento_fim'] ? date('Y-m-d\TH:i', strtotime($reserva['data_evento_fim'])) : '' ?>">

        <label for="numero_participantes_est">Número de Participantes</label>
        <input type="number" name="numero_participantes_est" id="numero_participantes_est"
            value="<?= $reserva['numero_participantes_est'] ?>" required>

        <label for="observacoes">Observações</label>
        <textarea name="observacoes" id="observacoes" rows="4"><?= htmlspecialchars($reserva['observacoes']) ?></textarea>

        <label for="total_previsto">Total Previsto (R$)</label>
        <input type="number" step="0.01" name="total_previsto" id="total_previsto"
            value="<?= $reserva['total_previsto'] ?>" readonly>

        <div class="total">Total Recalculado: R$ <span id="total">0.00</span></div>

        <label for="status">Status</label>
        <select name="status" required>
            <option value="pendente" <?= $reserva['status'] == "pendente" ? "selected" : "" ?>>Pendente</option>
            <option value="confirmada" <?= $reserva['status'] == "confirmada" ? "selected" : "" ?>>Confirmada</option>
            <option value="cancelada" <?= $reserva['status'] == "cancelada" ? "selected" : "" ?>>Cancelada</option>
            <option value="concluida" <?= $reserva['status'] == "concluida" ? "selected" : "" ?>>Concluída</option>
        </select>

        <button type="submit">Salvar Alterações</button>
        <a href="list_reservas.php" style="margin-left:10px;">⬅️ Voltar</a>
    </form>

    <script>
        const form = document.getElementById("formReserva");

        function calcularTotal() {
            let convidados = parseInt(document.getElementById("numero_participantes_est").value) || 0;
            let inicio = new Date(document.getElementById("data_evento_inicio").value);
            let fim = new Date(document.getElementById("data_evento_fim").value);

            let dias = 1;
            if (!isNaN(inicio) && !isNaN(fim) && fim > inicio) {
                let diff = Math.ceil((fim - inicio) / (1000 * 60 * 60 * 24));
                dias = diff > 0 ? diff + 1 : 1;
            }

            // Valor base do salão
            let valorBaseSalao = 2000;
            let total = valorBaseSalao * dias;

            // Acrescenta taxa por convidado
            total += convidados * 10;

            document.getElementById("total").innerText = total.toFixed(2);
            document.getElementById("total_previsto").value = total.toFixed(2);
        }

        // Recalcula ao alterar participantes ou datas
        form.addEventListener("input", calcularTotal);

        // Calcula assim que a página carregar
        window.onload = calcularTotal;
    </script>
</body>
</html>
