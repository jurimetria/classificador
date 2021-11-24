<?php
    session_start();
    include_once('config.php');
?>


<style>
    body{
        background: linear-gradient(to right, rgb(16, 100, 140), rgb(17, 54, 71));
        color: white;
        text-align: left;
        margin: 40px;
        font-family: Arial, Helvetica, sans-serif;
    }


    a:link, a:visited {
    background-color: white;
    color: black;
    border: 2px solid dodgerblue;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    border-radius: 6px;
    }

    a:hover, a:active {
    background-color: dodgerblue;
    color: white;
    }

    .links {
        padding: 15px;
    }

    .botoesAcoes{
        border: 2px solid white;
        color:dodgerblue;
        font-size: 15px;
        cursor: pointer;
        border-radius: 10px;
    }

    .containers{
        margin: 40px;
    }

    .botoesAcoes2{
    position: relative;}


</style>

<body>
<a class="botoesAcoes" href="index.php">Procurar Outra Pasta</a>
<br><br>
<a class="botoesAcoes" href="novaPasta.php">Cadastrar Nova Pasta</a>
<br><br><br><br>
<h1>Resultados da busca</h1>  
<br>


  

    <?php
        if(isset($_GET['submit-search'])) 
        {
            $search = $_GET['search'];
            $sql6 = "SELECT * FROM tb_folder WHERE id_pasta LIKE '%$search%'";
            $result = mysqli_query($conexao,$sql6);
            $queryResults = mysqli_num_rows($result);

            echo "<h2>Foram encontrados ".$queryResults." resultados:</h2>";

            if($queryResults > 0) 
            {
                while ($rowx = mysqli_fetch_assoc($result)) 
                {
                    echo "<a href='sistema.php?id_pasta=".$rowx['id_pasta'].
                    "'<div class='containers'>".$rowx['id_pasta']."</div>" 
                    ;
                }

            } 
            
            else 
                {
                    echo "<br><br> Sem resultados na busca! <br><br>
                    Confira se a pasta foi cadastrada no Judice até a meia noite de ontem";
                }

        }

    ?>

    </body>
