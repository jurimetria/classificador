<?php
    session_start();
    include_once('config.php');
    // print_r($_SESSION);
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }

    $pasta = "";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>L&P | CLassificador</title>
    <style>
        body{
            background: linear-gradient(to right, rgb(16, 100, 140), rgb(17, 54, 71));
            color: white;
            text-align: center;
        }
        .table-bg{
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px 15px 0 0;
        }
        .detalhes{
            text-align: left;
            padding: 50px;
            font-size: 20px;  
        }
        .botaoMais{
            cursor: pointer;

        }
        .botaoMais:hover {
        opacity: 0.6;
        }

        .editFolder{
            cursor: pointer;
            margin-left: 55;
            font-size: 15px;  
        }

        .editFolder:hover {
        opacity: 0.8;
                }

        * {
        box-sizing: border-box;
        }

        /* Style the search field */
        form.example input[type=text] {
        padding: 10px;
        font-size: 17px;
        border: 1px solid grey;
        float: left;
        width: 80%;
        background: #f1f1f1;

        }

        /* Style the submit button */
        form.example button {
        float: left;
        width: 20%;
        padding: 10px;
        background: #2196F3;
        color: white;
        font-size: 17px;
        border: 1px solid grey;
        border-left: none; /* Prevent double borders */
        cursor: pointer;
        }

        form.example button:hover {
        background: #0b7dda;
        }

        /* Clear floats */
        form.example::after {
        content: "";
        clear: both;
        display: table;
        }

        </style>
</head>
<body>
<!-- BARRA DE NAVEGAÇÃO -->
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">L&P | Classificador de Pastas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="d-flex">
                <a href="login.php" class="btn btn-danger me-5">Sair</a>
            </div>
        </nav>
        <br>

        <?php
            echo "<h2>Procure uma pasta: $pasta</h2>";
        ?>
        <br>
    </div>

    <form class="botoesAcoes" action="buscarPasta.php" method="GET">
        <input type="text" name="search" placeholder="...">
        <button type="submit" name="submit-search">Buscar</button>
    </form>



</body>
</html>