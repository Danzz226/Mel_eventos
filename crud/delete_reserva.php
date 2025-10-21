<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $usuario_id = $_SESSION['usuario_id'];

    // Deleta apenas reservas do usuário logado
    $stmt = $conn->prepare("DELETE FROM Reserva WHERE id_reserva = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id, $usuario_id);

    if ($stmt->execute()) {
        header("Location: list_reservas.php");
        exit;
    } else {
        echo "❌ Erro ao excluir reserva.";
    }
} else {
    echo "⚠️ ID inválido.";
}
?>
