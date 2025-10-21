<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

if (
    isset($_POST['id_reserva']) &&
    isset($_POST['id_salao']) &&
    isset($_POST['data_evento_inicio']) &&
    isset($_POST['data_evento_fim']) &&
    isset($_POST['numero_participantes_est']) &&
    isset($_POST['observacoes']) &&
    isset($_POST['total_previsto']) &&
    isset($_POST['status'])
) {
    $id_reserva = $_POST['id_reserva'];
    $id_salao = $_POST['id_salao'];
    $data_evento_inicio = $_POST['data_evento_inicio'];
    $data_evento_fim = $_POST['data_evento_fim'];
    $numero_participantes_est = $_POST['numero_participantes_est'];
    $observacoes = $_POST['observacoes'];
    $total_previsto = $_POST['total_previsto'];
    $status = $_POST['status'];

    $sql = "UPDATE Reserva SET 
                id_salao = ?, 
                data_evento_inicio = ?, 
                data_evento_fim = ?, 
                numero_participantes_est = ?, 
                observacoes = ?, 
                total_previsto = ?, 
                status = ?
            WHERE id_reserva = ?";

    $stmt = $conn->prepare($sql);
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
        header("Location: list_reservas.php");
        exit;
    } else {
        echo "❌ Erro ao atualizar reserva: " . $stmt->error;
    }
} else {
    echo "⚠️ Dados incompletos para atualização.";
}
?>
