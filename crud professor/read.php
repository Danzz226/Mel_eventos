<?php 
include "conexao.php";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário para banco de dados</title>
</head>
<body>
<h1>Inscrição para curso</h1>
    <form action="create.php" method="post">

        <label for="nome">Nome do aluno</label>
        <input type="text" name="nome" id="nome"><br><br>

        
        <label for="curso">Curso do aluno</label>
        <input type="text" name="curso" id="curso">

        <button type="submit">Enviar</button>
    </form>


    <hr>

    <table border="1" >
        <thead>
            <tr>
                <td>Id</td>
                <td>Nome</td>
                <td>Curso</td>
            </tr>
        </thead>
        <tbody>
            <?php 
            
                $sql = "SELECT id, nome, curso from alunos";

                $result = mysqli_query($conn, $sql);
            
                if (mysqli_num_rows($result) > 0) {
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        print_r("
                        <tr>
                            <td>".$row['id']."</td>
                            <td>".$row['nome']."</td>
                            <td>".$row['curso']."</td>
                        </tr>
                        ");
                    }

                }else {
                    print_r("<tr><td colspan='3'>Nenhum aluno foi cadastrado!</td></tr>");
                }

            ?>

        </tbody>
    </table>


</body>
</html>