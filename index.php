<?php
    session_start();
    include_once('config.php');
    

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }

    
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
                <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

 

            <!-- SAIR -->
            <div class="d-flex">
                <a href="login.php" class="btn btn-danger me-5">Sair</a>
            </div>
        </nav>
    </div>  


    <br><br>
        <!-- LINK PÁGINA RESUMO -->
        <div class="alingLeft">
        <button type="button" class="button" onclick="location.href='resumo.php'">Ir para Resumo</button>
        </div><br>


        <!-- CADASTRAR NOVA PASTA -->
        <div class='alingLeft '>
        <a class="button2 " href="novaPasta.php">Cadastrar Nova Pasta</a>
        </div>
        <br>


    

<br><br>
<h2 class=" alingLeft">Procure uma pasta:</h2><br>


    <!-- BUSCAR PASTA SEARCH BOX -->
    <div  class=" alingLeft">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <form class="searchF" action="buscarPasta.php" method="GET">
                <input type="text" name="search" placeholder="buscar pasta...">
                <button type="submit" name="submit-search"><i class="fa fa-search "></i></button>
            </form>
    </div>

</body>
</html>