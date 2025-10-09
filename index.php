<?php

include "connection.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    
    <h1>Formulario</h1>

    <form action="crud/create.php" method="post">
        <label for="name">Cadastro do evento:</label>
        <input type="text" id="cadastro_eventos" name="name" required><br><br>

        <label for="data">Data do evento:</label>
        <input type="date" id="data_eventos" name="data" required><br><br>

        <label for="quantidade">Quantidade de convidados:</label>
        <input type="number" id="quantidade_convidados" name="quantidade" required><br><br>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea><br><br>

        <input type="submit" value="Submit">
    </form>

</body>
</html>