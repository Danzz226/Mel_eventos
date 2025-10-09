<?php

include "connection.php";

if (!empty($_POST['usuario']) && !empty($_POST['senha'])) {

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM login WHERE usuario = '$usuario' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Login realizado com sucesso!";
    } else {
        echo "Login ou senha incorretos.";
    }
    

}