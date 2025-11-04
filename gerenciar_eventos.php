<?php
session_start();
include "conexao.php";

// Verifica se está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_nome = $_SESSION['usuario_nome'];
$usuario_id = $_SESSION['usuario_id'];

// Buscar salões
$saloes = $conn->query("SELECT id_salao, nome FROM Salao ORDER BY nome ASC");

// Se não existir salões, criar alguns
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Eventos - Mel Eventos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navegação Superior -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <h1>🎉 Mel Eventos</h1>
            </div>
            <ul class="nav-menu">
                <li><a href="home.php" class="nav-link">Voltar ao Início</a></li>
                <li class="user-info">
                    <span>👤 <?= htmlspecialchars($usuario_nome) ?></span>
                    <a href="logout.php" class="btn-logout">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            <h1 class="page-title">Gerenciar Eventos</h1>
            
            <!-- Formulário de Nova Reserva -->
            <section class="form-section">
                <h2>Nova Reserva</h2>
                <form action="create_reserva.php" method="post" id="formReserva" class="form-reserva">
                    <input type="hidden" name="id_usuario" value="<?= $usuario_id ?>">
                    
                    <div class="form-group">
                        <label for="id_salao">Selecione o Salão</label>
                        <select name="id_salao" id="id_salao" required>
                            <option value="">-- Escolha --</option>
                            <?php while($s = $saloes->fetch_assoc()): ?>
                                <option value="<?= $s['id_salao'] ?>"><?= $s['nome'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nome do Usuário</label>
                        <input type="text" value="<?= htmlspecialchars($usuario_nome) ?>" readonly>
                        <input type="hidden" name="nome_usuario" value="<?= htmlspecialchars($usuario_nome) ?>">
                    </div>

                    <div class="form-group">
                        <label for="data_evento_inicio">Data Início do Evento</label>
                        <input type="datetime-local" name="data_evento_inicio" id="data_evento_inicio" required>
                    </div>

                    <div class="form-group">
                        <label for="data_evento_fim">Data Fim do Evento</label>
                        <input type="datetime-local" name="data_evento_fim" id="data_evento_fim" required>
                        <div id="erroData" class="error-message" style="display:none;">⚠️ A data de fim não pode ser menor que a de início!</div>
                    </div>

                    <div class="form-group">
                        <label for="numero_participantes_est">Número Estimado de Participantes</label>
                        <input type="number" name="numero_participantes_est" id="numero_participantes_est" min="1" required>
                    </div>

                    <div class="form-group">
                        <label>Serviços Extras:</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="servicos[]" value="buffet" data-preco="50">
                                Buffet (R$ 50 por convidado)
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="servicos[]" value="decoracao" data-preco="1000">
                                Decoração (R$ 1.000 fixo)
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="servicos[]" value="som" data-preco="800">
                                Som e Iluminação (R$ 800 fixo)
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="observacoes">Observações</label>
                        <textarea name="observacoes" id="observacoes" rows="4"></textarea>
                    </div>

                    <input type="hidden" name="total_previsto" id="total_previsto">

                    <div class="total-display">
                        <strong>Total Previsto: R$ <span id="total">0.00</span></strong>
                    </div>

                    <button type="submit" class="btn-submit">Confirmar Reserva</button>
                </form>
            </section>

            <hr class="divider">

            <!-- Listagem de Reservas -->
            <section class="list-section">
                <h2>Minhas Reservas</h2>
                <div class="table-container">
                    <table class="table-reservas">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Salão</th>
                                <th>Data Início</th>
                                <th>Status</th>
                                <th>Total (R$)</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql = "SELECT 
                                        r.id_reserva,
                                        s.nome AS salao_nome,
                                        r.data_evento_inicio,
                                        r.status,
                                        r.total_previsto
                                    FROM Reserva r
                                    JOIN Salao s ON r.id_salao = s.id_salao
                                    WHERE r.id_usuario = $usuario_id
                                    ORDER BY r.data_evento_inicio DESC";

                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "
                                    <tr>
                                        <td>".$row['id_reserva']."</td>
                                        <td>".htmlspecialchars($row['salao_nome'])."</td>
                                        <td>".date("d/m/Y H:i", strtotime($row['data_evento_inicio']))."</td>
                                        <td><span class='status-badge status-".$row['status']."'>".htmlspecialchars($row['status'])."</span></td>
                                        <td>".number_format($row['total_previsto'], 2, ',', '.')."</td>
                                        <td>
                                            <a href='edit_reserva.php?id=".$row['id_reserva']."' class='btn-action btn-edit'>✏️ Editar</a>
                                            <a href='delete_reserva.php?id=".$row['id_reserva']."' class='btn-action btn-delete' onclick='return confirm(\"Excluir esta reserva?\")'>🗑️ Excluir</a>
                                        </td>
                                    </tr>
                                    ";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='no-data'>Nenhuma reserva foi cadastrada!</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <script src="assets/js/reservas.js"></script>
</body>
</html>

