<?php
include "../connection.php";

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}


if (!empty($_POST['id_reserva']) &&
    !empty($_POST['id_salao']) &&
    !empty($_POST['data_evento_inicio']) &&
    !empty($_POST['numero_participantes_est']) &&
    !empty($_POST['status'])) {

    $id_reserva = $_POST['id_reserva'];
    $id_salao = $_POST['id_salao'];
    $data_evento_inicio = $_POST['data_evento_inicio'];
    $data_evento_fim = !empty($_POST['data_evento_fim']) ? $_POST['data_evento_fim'] : null;
    $numero_participantes_est = $_POST['numero_participantes_est'];
    $observacoes = !empty($_POST['observacoes']) ? $_POST['observacoes'] : '';
    $total_previsto = !empty($_POST['total_previsto']) ? $_POST['total_previsto'] : 0.00;
    $status = $_POST['status'];

    $sql = "UPDATE Reserva 
            SET id_salao = ?, 
                data_evento_inicio = ?, 
                data_evento_fim = ?, 
                numero_participantes_est = ?, 
                observacoes = ?, 
                total_previsto = ?, 
                status = ?
            WHERE id_reserva = ?";

    $stmt = $conn->prepare($sql);

    // bind_param corrigido
    $stmt->bind_param(
        "issisdsi", 
        $id_salao,
        $data_evento_inicio,
        $data_evento_fim,
        $numero_participantes_est,
        $observacoes,
        $total_previsto,
        $status,
        $id_reserva
    );

    if ($stmt->execute()) {
        echo "✅ Reserva atualizada com sucesso!";
        echo "<br><a href='list_reservas.php'>Voltar à lista</a>";
    } else {
        echo "❌ Erro ao atualizar reserva: " . $stmt->error;
    }

    $stmt->close();

} else {
    echo "⚠️ Preencha todos os campos obrigatórios.";
}
?>
