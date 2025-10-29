<?php
include "conexao.php";

if (!empty($_POST['nome']) && !empty($_POST['senha']) && !empty($_POST['confirmar_senha'])) {
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($senha !== $confirmar_senha) {
        header("Location: register.php?msg=As senhas não coincidem");
        exit;
    }

    // Verifica se nome já existe
    $check_sql = "SELECT id_usuario FROM usuario WHERE nome = '$nome'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        header("Location: register.php?msg=Usuário já existe");
        exit;
    }

    // Inserir usuário (senha simples para compatibilidade)
    $sql = "INSERT INTO usuario (nome, senha, ativo) VALUES ('$nome', '$senha', 1)";

    if ($conn->query($sql)) {
        header("Location: register.php?msg=Cadastro realizado com sucesso!");
    } else {
        header("Location: register.php?msg=Erro ao cadastrar usuário: " . mysqli_error($conn));
    }
} else {
    header("Location: register.php?msg=Preencha todos os campos");
}
