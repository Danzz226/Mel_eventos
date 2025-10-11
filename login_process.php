<?php
session_start();
include "connection.php";

if (!empty($_POST['nome']) && !empty($_POST['senha'])) {
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM Usuario WHERE nome = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

            header("Location: crud/list_reservas.php");
            exit;
        } else {
            header("Location: login.php?error=Senha incorreta");
            exit;
        }
    } else {
        header("Location: login.php?error=Usuário não encontrado");
        exit;
    }
} else {
    header("Location: login.php?error=Preencha todos os campos");
    exit;
}
