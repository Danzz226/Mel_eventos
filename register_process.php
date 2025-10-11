<?php
include "connection.php";

if (!empty($_POST['nome']) && !empty($_POST['senha']) && !empty($_POST['confirmar_senha'])) {
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($senha !== $confirmar_senha) {
        header("Location: register.php?msg=As senhas não coincidem");
        exit;
    }

    // Verifica se nome já existe
    $check = $conn->prepare("SELECT id_usuario FROM Usuario WHERE nome = ?");
    $check->bind_param("s", $nome);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        header("Location: register.php?msg=Usuário já existe");
        exit;
    }
    $check->close();

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Usuario (nome, senha, ativo) VALUES (?, ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nome, $senha_hash);

    if ($stmt->execute()) {
        header("Location: register.php?msg=Cadastro realizado com sucesso!");
    } else {
        header("Location: register.php?msg=Erro ao cadastrar usuário");
    }

    $stmt->close();
} else {
    header("Location: register.php?msg=Preencha todos os campos");
}
