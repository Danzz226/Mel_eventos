<?php
session_start();
include "../connection.php";

// Impede acesso sem login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

// Buscar salões existentes
$saloes = $conn->query("SELECT id_salao, nome FROM Salao ORDER BY nome ASC");

// Caso não existam, cria alguns exemplos
if ($saloes->num_rows == 0) {
    $conn->query("INSERT INTO Salao (nome, descricao, capacidade_max, status) VALUES
        ('Salão Principal', 'Espaço amplo para grandes eventos', 300, 'ativo'),
        ('Salão de Festas Kids', 'Espaço para festas infantis', 80, 'ativo'),
        ('Salão VIP', 'Espaço exclusivo e reservado', 50, 'ativo')
    ");
    $saloes = $conn->query("SELECT id_salao, nome FROM Salao ORDER BY nome ASC");
}

// Dados do usuário logado
$usuario_nome = $_SESSION['usuario_nome'];
$usuario_id = $_SESSION['usuario_id'];
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
        .top-bar {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px;
        }
        .logout {
            background: #dc3545; padding: 8px 12px; border-radius: 5px;
            color: white; text-decoration: none;
        }
        .logout:hover { background: #b02a37; }
    </style>
</head>
<body>
    <div class="top-bar">
        <h2>Nova Reserva</h2>
        <div>
            👤 <?= htmlspecialchars($usuario_nome) ?> |
            <a href="../logout.php" class="logout">Sair</a>
        </div>
    </div>

    <form action="nova_create.php" method="POST" id="formReserva">
        <input type="hidden" name="id_usuario" value="<?= $usuario_id ?>">

        <!-- Seleção do Salão -->
        <label for="id_salao">Selecione o Salão</label>
        <select name="id_salao" id="id_salao" required>
            <option value="">-- Escolha --</option>
            <?php while($s = $saloes->fetch_assoc()): ?>
                <option value="<?= $s['id_salao'] ?>"><?= $s['nome'] ?></option>
            <?php endwhile; ?>
        </select>

        <!-- Nome do Usuário -->
        <label>Nome do Usuário</label>
        <input type="text" value="<?= htmlspecialchars($usuario_nome) ?>" readonly>
        <input type="hidden" name="nome_usuario" value="<?= htmlspecialchars($usuario_nome) ?>">

        <!-- Datas -->
        <label for="data_evento_inicio">Data Início do Evento</label>
        <input type="datetime-local" name="data_evento_inicio" id="data_evento_inicio" required>

        <label for="data_evento_fim">Data Fim do Evento</label>
        <input type="datetime-local" name="data_evento_fim" id="data_evento_fim" required>
        <div id="erroData" style="color:red; display:none;">⚠️ A data de fim não pode ser menor que a de início!</div>

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
        const inicio = document.getElementById("data_evento_inicio");
        const fim = document.getElementById("data_evento_fim");
        const erroData = document.getElementById("erroData");

        inicio.addEventListener("change", () => {
            fim.min = inicio.value;
            validarDatas();
        });

        fim.addEventListener("change", validarDatas);

        function validarDatas() {
            if (inicio.value && fim.value && fim.value < inicio.value) {
                erroData.style.display = "block";
                fim.value = "";
            } else {
                erroData.style.display = "none";
            }
        }

        function calcularTotal() {
            let convidados = parseInt(document.getElementById("numero_participantes_est").value) || 0;
            let dataInicio = new Date(inicio.value);
            let dataFim = new Date(fim.value);
            let dias = 1;

            if (!isNaN(dataInicio) && !isNaN(dataFim) && dataFim > dataInicio) {
                let diff = Math.ceil((dataFim - dataInicio) / (1000 * 60 * 60 * 24));
                dias = diff > 0 ? diff + 1 : 1;
            }

            let total = 0;

            document.querySelectorAll('input[name="servicos[]"]:checked').forEach(serv => {
                let preco = parseFloat(serv.getAttribute("data-preco"));
                if (serv.value === "buffet") {
                    total += preco * convidados;
                } else {
                    total += preco;
                }
            });

            total += 2000 * dias; // valor base diário do salão
            total += convidados * 10; // custo adicional por convidado

            document.getElementById("total").innerText = total.toFixed(2);
            document.getElementById("total_previsto").value = total.toFixed(2);
        }

        document.getElementById("formReserva").addEventListener("input", calcularTotal);
    </script>
</body>
</html>
