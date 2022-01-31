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

<!-- COLUNAS CENTRAIS -->
<div class="row">
        <!-- COLUNA DA ESQUERDA -->
        <div class="column side2 alignLeft">

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

    </div>

    <!-- Prepara o csv para ser lido como uma tabela array -->
    <?php
    $lines = file('C:/xampp/htdocs/dashboard/datalake/alts_fase_class.csv');
    $header = array_shift($lines);
    $states = array_map(function ($line) use ($header) {
        $state = array_combine(
            str_getcsv($header),
            str_getcsv($line)
        );
        return $state;
    }, $lines);
    ?>
    
        

    <div class="column side2 alignCenter">
    <br><br>
        <h1 class='alignRight'>Pastas com nova alteração de Fase</h1>  <br>
        <h3 class='alignRight'>Atualizado sempre nas segundas-feiras às 7h</h3><br><br>
        
        
            <table  class='table text-white table-bg'>
                <thead>
                    <tr>
                        <th scope='col'>Pasta</th>
                        <th scope='col'>Nova Fase</th>
                        <th scope='col'>Unidade</th>
                        <th scope='col'>Área</th>
                        <th scope='col'>Ir</th>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach($states as $row) 
                        {echo "<tr>";
                            echo "<td>".$row['pasta']."</td>";
                            echo "<td>".$row['novo_status_fase']."</td>";
                            echo "<td>".$row['unidade']."</td>";
                            echo "<td>".$row['area']."</td>";
                            echo "<td>
                        <a class='btn btn-sm btn-primary ' href='sistema.php?id_pasta=$row[pasta]' name='id_pasta' title='Ver Pasta'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-right-square' viewBox='0 0 16 16'>
                            <path fill-rule='evenodd' d='M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5.854 8.803a.5.5 0 1 1-.708-.707L9.243 6H6.475a.5.5 0 1 1 0-1h3.975a.5.5 0 0 1 .5.5v3.975a.5.5 0 1 1-1 0V6.707l-4.096 4.096z'/>
                        </svg>
                        </a> 
                        </td>";
                            echo "</tr>";
                    }
                    ?>
                
                </tbody> 
            </table> 
        
    </div>
                
   

    
</body>
</html>


    