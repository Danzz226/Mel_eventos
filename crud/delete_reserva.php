<?php
include "../connection.php";

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}


// Verifica se o ID foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("⚠️ ID da reserva não informado.");
}

$id_reserva = $_GET['id'];

// Preparar e executar exclusão
$sql = "DELETE FROM Reserva WHERE id_reserva = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_reserva);

if ($stmt->execute()) {
    echo "✅ Reserva excluída com sucesso!";
    echo "<br><a href='list_reservas.php'>Voltar à lista</a>";
} else {
    echo "❌ Erro ao excluir reserva: " . $stmt->error;
}

$stmt->close();
?>
