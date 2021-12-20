<?php
    session_start();
    include_once('config.php');
    include_once('config2.php');
    include('salvaDados.php');
    

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }

    
    include('style.css');
    include('navBarClean.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>L&P | CLassificador</title>
    <!-- FAVICON -->
    <link rel="shortcut icon" href="https://lp-classificador.s3.amazonaws.com/img/favicon.ico" type="image/x-icon" />
</head>

<body>
    <!-- BARRA DE NAVEGAÇÃO -->
    <?php echo $navBarClean ?><br>


    <br><br>
        <!-- LINK PÁGINA RESUMO -->
        <div class="alignLeft">
        <button type="button" class="button" onclick="location.href='resumo.php'">Ir para Resumo</button>
        </div><br>


        <!-- CADASTRAR NOVA PASTA -->
        <div class='alignLeft '>
        <a class="button2 " href="pastaNova.php">Cadastrar Nova Pasta</a>
        </div>
        <br>


    

<br><br>
<h2 class=" alignLeft">Procure uma pasta:</h2><br>


    <!-- BUSCAR PASTA SEARCH BOX -->
    <div  class=" alignLeft">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <form class="searchF" action="pastaBuscar.php" method="GET">
                <input type="text" name="search" placeholder="buscar pasta...">
                <button type="submit" name="submit-search"><i class="fa fa-search "></i></button>
            </form>
    </div>

</body>
</html>