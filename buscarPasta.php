<?php
    session_start();
    include_once('config.php');
    include('style.css');
?>




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
