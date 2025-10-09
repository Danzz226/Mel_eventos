<?php
include "../connection.php";

// Buscar salões
$saloes = $conn->query("SELECT id_salao, nome FROM Salao ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Reserva de Evento</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 600px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, textarea, select {
            width: 100%; padding: 8px; margin-top: 5px;
            border: 1px solid #ccc; border-radius: 5px;
        }
        .checkbox-group { margin-top: 10px; }
        button {
            margin-top: 15px; padding: 10px 15px;
            background-color: #007bff; color: #fff;
            border: none; border-radius: 5px; cursor: pointer;
        }
        button:hover { background-color: #0056b3; }
        .total { font-size: 18px; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>
    <h2>Fazer Nova Reserva</h2>

    <form action="nova_create.php" method="POST" id="formReserva">
        <!-- Seleção do Salão -->
        <label for="id_salao">Selecione o Salão</label>
        <select name="id_salao" id="id_salao" required>
            <option value="">-- Escolha --</option>
            <?php while($s = $saloes->fetch_assoc()): ?>
                <option value="<?= $s['id_salao'] ?>"><?= $s['nome'] ?></option>
            <?php endwhile; ?>
        </select>

        <!-- Nome e email do usuário -->
        <label for="nome_usuario">Nome do Usuário</label>
        <input type="text" name="nome_usuario" id="nome_usuario" required>

        <label for="email_usuario">Email do Usuário</label>
        <input type="email" name="email_usuario" id="email_usuario" required>

        <!-- Datas -->
        <label for="data_evento_inicio">Data Início do Evento</label>
        <input type="datetime-local" name="data_evento_inicio" id="data_evento_inicio" required>

        <label for="data_evento_fim">Data Fim do Evento</label>
        <input type="datetime-local" name="data_evento_fim" id="data_evento_fim" required>

        <!-- Número de participantes -->
        <label for="numero_participantes_est">Número Estimado de Participantes</label>
        <input type="number" name="numero_participantes_est" id="numero_participantes_est" min="1" required>

        <!-- Serviços extras -->
        <div class="checkbox-group">
            <label>Serviços Extras:</label>
            <input type="checkbox" name="servicos[]" value="buffet" data-preco="50"> Buffet (R$ 50 por convidado)<br>
            <input type="checkbox" name="servicos[]" value="decoracao" data-preco="1000"> Decoração (R$ 1.000 fixo)<br>
            <input type="checkbox" name="servicos[]" value="som" data-preco="800"> Som e Iluminação (R$ 800 fixo)<br>
        </div>

        <label for="observacoes">Observações</label>
        <textarea name="observacoes" id="observacoes" rows="4"></textarea>

        <input type="hidden" name="total_previsto" id="total_previsto">

        <div class="total">Total Previsto: R$ <span id="total">0.00</span></div>

        <button type="submit">Confirmar Reserva</button>
    </form>

    <script>
        function calcularTotal() {
            let convidados = parseInt(document.getElementById("numero_participantes_est").value) || 0;

            let inicio = new Date(document.getElementById("data_evento_inicio").value);
            let fim = new Date(document.getElementById("data_evento_fim").value);
            let dias = 1;

            if (!isNaN(inicio) && !isNaN(fim) && fim > inicio) {
                let diff = Math.ceil((fim - inicio) / (1000 * 60 * 60 * 24));
                dias = diff > 0 ? diff + 1 : 1;
            }

            let total = 0;

            // Buffet cobra por convidado
            document.querySelectorAll('input[name="servicos[]"]:checked').forEach(serv => {
                let preco = parseFloat(serv.getAttribute("data-preco"));
                if (serv.value === "buffet") {
                    total += preco * convidados;
                } else {
                    total += preco;
                }
            });

            // Valor base do salão (exemplo: 2000 por dia)
            let valorSalao = 2000 * dias;
            total += valorSalao;

            // Multiplicador de convidados (exemplo +10 por convidado)
            total += convidados * 10;

            document.getElementById("total").innerText = total.toFixed(2);
            document.getElementById("total_previsto").value = total.toFixed(2);
        }

        document.getElementById("formReserva").addEventListener("input", calcularTotal);
    </script>
</body>
</html>
