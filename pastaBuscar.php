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
    include('navBarClean.php');

 
?>

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
<?php echo $navBarClean ?>


    <div class='alignLeft alignTop'>
        
            <!-- BUSCAR PASTA SEARCH BOX -->
        <div>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                <form class="searchF" action="pastaBuscar.php" method="GET">
                    <input type="text" name="search" placeholder="buscar pasta...">
                    <button type="submit" name="submit-search"><i class="fa fa-search "></i></button>
                </form>
        </div>

        <div>
            <br>
            <a class="button2" href="pastaNova.php">Cadastrar Nova Pasta</a>
        </div>

    </div>

    <br><br>
    <h1 class='alignLeft'>Resultados da busca</h1>  
    <br>

    <?php
        if(isset($_GET['submit-search'])) 
        {
            $search = $_GET['search'];
            $sql6 = "SELECT DISTINCT * FROM tb_folder WHERE id_pasta LIKE '%$search%' ORDER BY id_pasta ASC";
            $result = mysqli_query($conexao,$sql6);
            $queryResults = mysqli_num_rows($result);

            echo "<h2 class='alignLeft'>Foram encontrados ".$queryResults." resultados:</h2><br>";

            if($queryResults > 0) 
            {
                while ($rowx = mysqli_fetch_assoc($result)) 
                {
                    echo "<div class='alignLeft'><a class='resultBusca' href='sistema.php?id_pasta=".$rowx['id_pasta'].
                    "'<div class='alignLeft '>".$rowx['id_pasta']."<br><br></div></div>" 
                    ;
                }

            } 
            
            else 
                {
                    echo "<br><br><h2> Sem resultados na busca! <br>Certifique-se que a pasta foi cadastrada no Judice até a meia noite de ontem <br> Ou tente buscar por um termo mais abrangente </h2><br><br>";
                }

        }

    ?>

</body>
