<?php
session_start();

// Redireciona para a página inicial
if (!isset($_SESSION['usuario_id'])) {
    header("Location: pages/login.php");
    exit;
} else {
    header("Location: pages/home.php");
    exit;
}
