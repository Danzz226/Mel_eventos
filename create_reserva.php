<?php
include "conexao.php";

$id_usuario = $_POST['id_usuario'];
$id_salao = $_POST['id_salao'];
$data_evento_inicio = $_POST['data_evento_inicio'];
$data_evento_fim = $_POST['data_evento_fim'];
$numero_participantes_est = $_POST['numero_participantes_est'];
$observacoes = $_POST['observacoes'];
$total_previsto = $_POST['total_previsto'];

$sql = "INSERT INTO Reserva(id_usuario, id_salao, data_evento_inicio, data_evento_fim, numero_participantes_est, observacoes, total_previsto, status) VALUES ('$id_usuario','$id_salao','$data_evento_inicio','$data_evento_fim','$numero_participantes_est','$observacoes','$total_previsto','pendente')";

if (mysqli_query($conn,$sql)) {
    echo "Nova reserva inserida com sucesso!!";
    echo "<br><a href='index.php'>Voltar</a>";
} else {
    echo "Erro ao inserir: ". mysqli_error($conn);
}
?>