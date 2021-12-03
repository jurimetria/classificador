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

            <!-- BOTAO SAIR -->
            <div class="d-flex">
                <a href="login.php" class="btn btn-danger me-5">Sair</a>
            </div>
        </nav>
    </div>  


    <div class='alingLeft alingTop'>
        <br><br>
        <div>
            <a class="button2" href="index.php">Procurar Outra Pasta</a>
        </div>

        <div>
            <br>
            <a class="button2" href="novaPasta.php">Cadastrar Nova Pasta</a>
        </div>

    </div>

    <br><br>
    <h1 class='alingLeft'>Resultados da busca</h1>  
    <br>

    <?php
        if(isset($_GET['submit-search'])) 
        {
            $search = $_GET['search'];
            $sql6 = "SELECT * FROM tb_folder WHERE id_pasta LIKE '%$search%'";
            $result = mysqli_query($conexao,$sql6);
            $queryResults = mysqli_num_rows($result);

            echo "<h2 class='alingLeft'>Foram encontrados ".$queryResults." resultados:</h2><br>";

            if($queryResults > 0) 
            {
                while ($rowx = mysqli_fetch_assoc($result)) 
                {
                    echo "<div class='alingLeft'><a class='resultBusca' href='sistema.php?id_pasta=".$rowx['id_pasta'].
                    "'<div class='alingLeft '>".$rowx['id_pasta']."<br><br></div></div>" 
                    ;
                }

            } 
            
            else 
                {
                    echo "<br><br> Sem resultados na busca! <br><br>";
                }

        }

    ?>

</body>
