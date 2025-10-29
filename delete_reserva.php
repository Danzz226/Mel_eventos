<?php
include "conexao.php";

$id = $_GET['id'];

$sql_delete = "DELETE FROM Reserva WHERE id_reserva = $id";

if (mysqli_query($conn, $sql_delete)) {
    print_r("Registro excluído com sucesso! <a href='index.php'>Voltar</a>");
} else {
    echo "Erro ao excluir um registro!". mysqli_error($conn);
}
?>