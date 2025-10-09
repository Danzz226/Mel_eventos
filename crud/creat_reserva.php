<?php
include "../connection.php";

// Buscar salões existentes
$saloes = $conn->query("SELECT id_salao, nome FROM Salao ORDER BY nome ASC");

// Se não houver salões, podemos cadastrar alguns padrões
if ($saloes->num_rows == 0) {
    $conn->query("INSERT INTO Salao (nome, descricao, capacidade_max, status) VALUES
        ('Salão Principal', 'Espaço amplo para grandes eventos', 300, 'ativo'),
        ('Salão de Festas Kids', 'Espaço para festas infantis', 80, 'ativo'),
        ('Salão VIP', 'Espaço exclusivo e reservado', 50, 'ativo')
    ");
    $saloes = $conn->query("SELECT id_salao, nome FROM Salao ORDER BY nome ASC");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Reserva</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 500px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, textarea, select {
            width: 100%; padding: 8px; margin-top: 5px;
            border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            margin-top: 15px; padding: 10px 15px;
            background-color: #28a745; color: #fff;
            border: none; border-radius: 5px; cursor: pointer;
        }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>
    <h2>Cadastrar Nova Reserva</h2>

    <form action="create.php" method="POST">
        <!-- Usuário digitado -->
        <label for="nome_usuario">Nome do Usuário</label>
        <input type="text" name="nome_usuario" id="nome_usuario" required>

        <label for="email_usuario">Email do Usuário</label>
        <input type="email" name="email_usuario" id="email_usuario" required>

        <!-- Salão já cadastrado -->
        <label for="id_salao">Salão</label>
        <select name="id_salao" id="id_salao" required>
            <option value="">Selecione o salão</option>
            <?php while($s = $saloes->fetch_assoc()): ?>
                <option value="<?= $s['id_salao'] ?>"><?= $s['nome'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="data_evento_inicio">Data Início do Evento</label>
        <input type="datetime-local" name="data_evento_inicio" id="data_evento_inicio" required>

        <label for="data_evento_fim">Data Fim do Evento</label>
        <input type="datetime-local" name="data_evento_fim" id="data_evento_fim">

        <label for="numero_participantes_est">Número Estimado de Participantes</label>
        <input type="number" name="numero_participantes_est" id="numero_participantes_est" required>

        <label for="observacoes">Observações</label>
        <textarea name="observacoes" id="observacoes" rows="4"></textarea>

        <label for="forma_pagamento">Forma de Pagamento</label>
        <select name="forma_pagamento" id="forma_pagamento">
            <option value="">Selecione...</option>
            <option value="cartao">Cartão</option>
            <option value="pix">PIX</option>
            <option value="boleto">Boleto</option>
            <option value="transferencia">Transferência</option>
        </select>

        <label for="total_previsto">Total Previsto (R$)</label>
        <input type="number" step="0.01" name="total_previsto" id="total_previsto">

        <button type="submit">Salvar Reserva</button>
    </form>
</body>
</html>
