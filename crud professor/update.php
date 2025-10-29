<?php 

include "conexao.php";

$id = $_POST['id'];
$nome = $_POST['nome'];
$curso = $_POST['curso'];

$sql_update = "UPDATE alunos SET nome='$nome', curso='$curso' WHERE id = $id";

if (mysqli_query($conn, $sql_update)) {
    print_r("Registro atualizado com sucesso!    <a href='index.php'>Voltar</a>
");
}else {
    echo "Erro ao atualizar um registro!". mysqli_error($conn);
}



?>