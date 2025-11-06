<?php
session_start();
unset($_SESSION['admin_autenticado']);
header("Location: ../crud_operations/gerenciar_eventos.php");
exit;

