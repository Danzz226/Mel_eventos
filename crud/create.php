<?php
include "../connection.php";

// Verifica se os campos foram enviados
if (
    !empty($_POST['id_usuario']) &&
    !empty($_POST['id_salao']) &&
    !empty($_POST['data_evento_inicio']) &&
    !empty($_POST['numero_participantes_est'])
) {
    $id_usuario = $_POST['id_usuario'];
    $id_salao = $_POST['id_salao'];
    $data_evento_inicio = $_POST['data_evento_inicio'];
    $data_evento_fim = !empty($_POST['data_evento_fim']) ? $_POST['data_evento_fim'] : null;
    $numero_participantes_est = $_POST['numero_participantes_est'];
    $observacoes = !empty($_POST['observacoes']) ? $_POST['observacoes'] : '';
    $forma_pagamento = !empty($_POST['forma_pagamento']) ? $_POST['forma_pagamento'] : '';
    $total_previsto = !empty($_POST['total_previsto']) ? $_POST['total_previsto'] : 0.00;

    // Status padrão: pendente
    $status = 'pendente';

    // Query de inserção na tabela Reserva
    $sql = "INSERT INTO Reserva (
                id_usuario,
                id_salao,
                data_evento_inicio,
                data_evento_fim,
                numero_participantes_est,
                observacoes,
                forma_pagamento,
                total_previsto,
                status
            ) VALUES (
                '$id_usuario',
                '$id_salao',
                '$data_evento_inicio',
                " . ($data_evento_fim ? "'$data_evento_fim'" : "NULL") . ",
                '$numero_participantes_est',
                '$observacoes',
                '$forma_pagamento',
                '$total_previsto',
                '$status'
            )";

    if (mysqli_query($conn, $sql)) {
        echo "Nova reserva cadastrada com sucesso!";
    } else {
        echo "Erro ao inserir reserva: " . mysqli_error($conn);
    }
} else {
    echo "Por favor, preencha todos os campos obrigatórios.";
}
?>