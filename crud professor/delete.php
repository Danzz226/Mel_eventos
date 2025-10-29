<?php
include "conexao.php";

$id = $_GET['id'];

$sql_delete = "DELETE FROM alunos WHERE id = $id";


if (mysqli_query($conn, $sql_delete)) {
    print_r("Registro excluido com sucesso!    <a href='index.php'>Voltar</a>
");
}else {
    echo "Erro ao excluir um registro!". mysqli_error($conn);
}

