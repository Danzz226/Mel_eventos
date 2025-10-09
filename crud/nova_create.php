<?php
include "../connection.php";

// Verifica se os campos obrigatórios foram enviados
if (
    !empty($_POST['nome_usuario']) &&
    !empty($_POST['email_usuario']) &&
    !empty($_POST['id_salao']) &&
    !empty($_POST['data_evento_inicio']) &&
    !empty($_POST['numero_participantes_est'])
) {
    $nome_usuario = $_POST['nome_usuario'];
    $email_usuario = $_POST['email_usuario'];
    $id_salao = $_POST['id_salao'];
    $data_evento_inicio = $_POST['data_evento_inicio'];
    $data_evento_fim = !empty($_POST['data_evento_fim']) ? $_POST['data_evento_fim'] : null;
    $numero_participantes_est = $_POST['numero_participantes_est'];
    $observacoes = !empty($_POST['observacoes']) ? $_POST['observacoes'] : '';
    $total_previsto = !empty($_POST['total_previsto']) ? $_POST['total_previsto'] : 0.00;

    $status = 'pendente';

    // Verificar se usuário já existe
    $sqlUser = "SELECT id_usuario FROM Usuario WHERE email = ?";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("s", $email_usuario);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($resultUser->num_rows > 0) {
        $row = $resultUser->fetch_assoc();
        $id_usuario = $row['id_usuario'];
    } else {
        // Criar novo usuário
        $sqlInsertUser = "INSERT INTO Usuario (nome, email, ativo) VALUES (?, ?, 1)";
        $stmtInsert = $conn->prepare($sqlInsertUser);
        $stmtInsert->bind_param("ss", $nome_usuario, $email_usuario);
        $stmtInsert->execute();
        $id_usuario = $stmtInsert->insert_id;
        $stmtInsert->close();
    }
    $stmtUser->close();

    // Inserir reserva
    $sqlReserva = "INSERT INTO Reserva (
            id_usuario,
            id_salao,
            data_evento_inicio,
            data_evento_fim,
            numero_participantes_est,
            observacoes,
            total_previsto,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmtReserva = $conn->prepare($sqlReserva);
    $stmtReserva->bind_param(
        "issisdsi",
        $id_usuario,
        $id_salao,
        $data_evento_inicio,
        $data_evento_fim,
        $numero_participantes_est,
        $observacoes,
        $total_previsto,
        $status
    );

    if ($stmtReserva->execute()) {
        $id_reserva = $stmtReserva->insert_id;

        echo "<h3>✅ Reserva cadastrada com sucesso!</h3>";
        echo "<p>ID da Reserva: $id_reserva</p>";

        echo "<a href='list_reservas.php' style='
            display:inline-block;
            margin-top:10px;
            padding:8px 12px;
            background-color:#28a745;
            color:white;
            text-decoration:none;
            border-radius:5px;
        '>📋 Listar Reservas</a>";

        if (!empty($_POST['servicos'])) {
            echo "<h4>Serviços adicionados:</h4>";
            foreach ($_POST['servicos'] as $servico) {
                echo "<p>- " . htmlspecialchars($servico) . "</p>";
            }
        }
    } else {
        echo "❌ Erro ao inserir reserva: " . $stmtReserva->error;
    }

    $stmtReserva->close();

} else {
    echo "⚠️ Por favor, preencha todos os campos obrigatórios.";
}
?>
