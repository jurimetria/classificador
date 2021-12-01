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

    $data_tb = $pdo->query('SELECT * FROM tb_probabilidade')->fetchAll();

// Salva dados da última alteração
    $logado = $_SESSION['email'];
    date_default_timezone_set('America/Sao_Paulo');
    $horario = date('m/d/Y h:i:s a', time());

    include('script.js');
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
    <h3>Tabela de Probabilidades</h3><br>
        <table class="table text-white table-bg">
            <thead>
                <tr>
                
                    <th scope="col">Probabilidade (texto)</th>
                    <th scope="col">Prob Descrição (texto)</th>
                    <th scope="col">Prob % (texto)</th>
                    <th scope="col">Prob Considerado (texto)</th>
                    <th scope="col">Prob Média (texto)</th>
                    <th scope="col">Prob Máx (texto)</th>
                    <th scope="col">Prob Min (texto)</th>
                  
                </tr>
            </thead>
            
            <tbody>
                <?php foreach($data_tb as $row) {
                        echo "<tr>";
                        echo "<td>".$row['probabilidade']."</td>";
                        echo "<td>".$row['prob_txt']."</td>";
                        echo "<td>".$row['prob_perc']."</td>";
                        echo "<td>".$row['prob_considerado']."</td>";
                        echo "<td>".$row['prob_med']."</td>";
                        echo "<td>".$row['prob_max']."</td>";
                        echo "<td>".$row['prob_min']."</td>";
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