<?php
session_start();
include "../includes/conexao.php";

if (!empty($_POST['nome']) && !empty($_POST['senha'])) {
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE nome = '$nome'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Verificar senha (simples para compatibilidade)
        if ($senha === $usuario['senha'] || password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

            header("Location: home.php");
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

