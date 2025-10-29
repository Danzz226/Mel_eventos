<?php

include "conexao.php";

$nome = $_POST['nome'];
$curso = $_POST['curso'];

$sql = "INSERT INTO alunos(nome,curso) VALUES ('$nome','$curso')";

if (mysqli_query($conn,$sql)) {

    echo "Novo registro inserido com sucesso!!";
}else {
    echo "Erro ao inserir : ". mysqli_error($conn);
}

