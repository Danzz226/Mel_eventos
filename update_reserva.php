<?php
include "conexao.php";

$id_reserva = $_POST['id_reserva'];
$id_salao = $_POST['id_salao'];
$data_evento_inicio = $_POST['data_evento_inicio'];
$data_evento_fim = $_POST['data_evento_fim'];
$numero_participantes_est = $_POST['numero_participantes_est'];
$observacoes = $_POST['observacoes'];
$total_previsto = $_POST['total_previsto'];
$status = $_POST['status'];

$sql_update = "UPDATE Reserva SET id_salao='$id_salao', data_evento_inicio='$data_evento_inicio', data_evento_fim='$data_evento_fim', numero_participantes_est='$numero_participantes_est', observacoes='$observacoes', total_previsto='$total_previsto', status='$status' WHERE id_reserva = $id_reserva";

if (mysqli_query($conn, $sql_update)) {
    print_r("Registro atualizado com sucesso! <a href='index.php'>Voltar</a>");
} else {
    echo "Erro ao atualizar um registro!". mysqli_error($conn);
}
?>