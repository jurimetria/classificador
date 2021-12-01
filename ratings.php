<?php
    session_start();

    include('config2.php');

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
    
    $pdo = conectar();

    $data_tb = $pdo->query('SELECT * FROM tb_ratings')->fetchAll();

    // Salva dados da última alteração
    $logado = $_SESSION['email'];
    date_default_timezone_set('America/Sao_Paulo');
    $horario = date('m/d/Y h:i:s a', time());
 

include('style.css');

?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>L&P | CLassificador</title>
    
</head>
<body>
<!-- BARRA DE NAVEGAÇÃO -->
<div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">L&P | Classificador de Pastas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="d-flex">
                <a href="login.php" class="btn btn-danger me-5">Sair</a>
            </div>
        </nav>
    </div>  

<!-- BOTÃO VOLTAR -->
<div class='alingLeft alingTop'>
        <button class='voltar' onclick="goBack()">Voltar</button>
    </div>



    <div class="m-5">
    <h3>Tabela de Ratings</h3><br>
        <table class="table text-white table-bg">
            <thead>
                <tr>
                
                    <th scope="col">rating (texto)</th>
                    <th scope="col">Expectativa de ganho (texto)</th>
                    <th scope="col">Comissão (Número)</th>
                    <th scope="col">Valor Máximo (Número)</th>
                    <th scope="col">Valor Mínimo (Número)</th>
                  
                </tr>
            </thead>

            <tbody>
                <?php foreach($data_tb as $row) {
                        echo "<tr>";
                        echo "<td>".$row['rating']."</td>";
                        echo "<td>".$row['expectativa_ganho']."</td>";
                        echo "<td>".number_format($row['comissao'],2,",",".")."</td>";
                        echo "<td>".number_format($row['val_max'],2,",",".")."</td>";
                        echo "<td>R$ ".number_format($row['val_min'],2,",",".")."</td>";
                        echo "</tr>";}
                    
                ?>
            </tbody>
        </table>
    </div>



</body>
</html>

<script>
function goBack() {
  window.history.back();
}
</script>