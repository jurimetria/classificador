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

    include('select.php');
    include('script.js');


   
// GROUP BY f.id_pasta 

    $ver_ano_aval = '';
    $query = "SELECT DISTINCT ano_aval FROM
        tb_folder  ORDER BY idtb_folder DESC";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
    $ver_ano_aval .= '<option value="'.$row['ano_aval'].'">'.$row['ano_aval'].'</option>';
    }

    $ver_mes_aval = '';
    $query = "SELECT DISTINCT mes_aval FROM tb_folder 
        ORDER BY mes_aval_n ASC";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
    $ver_mes_aval .= '<option value="'.$row['mes_aval'].'">'.$row['mes_aval'].'</option>';
        }



    if (isset($_POST['enviar_busca']))
    {

        $mes_aval = $_POST['search_mes'];
        $ano_aval = $_POST['search_ano'];
        $state_prep .= 'WHERE (ano_aval=\''.$ano_aval.'\' AND mes_aval=\''.$mes_aval.'\') GROUP BY f.id_pasta ';
        $teste = "1";

    } 
    else{$state_prep .= 'WHERE * GROUP BY f.id_pasta ';
        $teste = "0";

    }

    $state= $pdo->prepare($state_prep);
    $state->execute();
    $data_tb = $state->fetchAll();



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
    
    <script src="table2excel.js"></script>
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

                <!-- RATINGS -->
    <div class="container-fluid ">
    <button type="button" class="buttTop" onclick="location.href='ratings.php'">Ratings</button>
    </div><br>
    
                <!-- PROBABILIDADES -->
                <div class="container-fluid ">
    <button type="button" class="buttTop" onclick="location.href='prob.php'">Probabilidades</button>
    </div><br>

    <!-- SAIR -->
    <div class="d-flex">
        <a href="login.php" class="btn btn-danger me-5">Sair</a>
    </div>
</nav>
</div>  


<br>
    <!-- BOTÃO VOLTAR -->
    <div class='alingLeft alingTop'>
        <button class='voltar' onclick="goBack()">Voltar</button>
    </div>
    <!-- TITULO DA PAGINA -->
    <h1>Resumo das Classificações</h1>

    <!-- RESULTADOS DA FILTRAGEM -->
    <p id="fontSize19"><?php if ($teste==="1"){echo "Resultados de "; echo $mes_aval; echo " de "; echo $ano_aval;} else{echo "Escolha um período";} ?></p>



            <!-- CADASTRAR NOVA PASTA -->
            <div class='alingLeft '>
        <a class="button2 " href="novaPasta.php">Cadastrar Nova Pasta</a>
        </div>
        <br>

    <!-- BUSCAR PASTA SEARCH BOX -->
    <div  class="buscar alingLeft">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <form class="searchF" action="buscarPasta.php" method="GET">
                <input type="text" name="search" placeholder="buscar pasta...">
                <button type="submit" name="submit-search"><i class="fa fa-search"></i></button>
            </form>


             <!-- EXPORTAR TABELA EXCEL -->
             <br>
            <button class="botaoFiltro2" id="downloadExcel">Exportar Tabela </button>

    </div>




 <!-- FILTRO MES E ANO -->
 <div class='row'>
    <section class="column-center">
            <div>
            <form name="search_form" action="resumo.php" method="POST"> 
                <select name="search_mes" id="search_mes"  required>
                    <option value="">Selecione o Mês</option>
                    <?php echo $ver_mes_aval; ?>
                </select>
            </div>
            <div>
                <select name="search_ano" id="search_ano"  required>
                    <option value="">Selecione o Ano</option>
                    <?php echo $ver_ano_aval; ?>
                </select>
            </div>
            <div>
                <button type="submit" name="enviar_busca" id="filter" class="botaoFiltro">Filtrar</button>
            </div>
            </form>
        
    </section>
</div>




    <!-- TABELA PEDIDOS -->
    <div class="m-5">
        <table id="tabelaResumo" class="table text-white table-bg">
            <thead>
                <tr>
                    <th scope="col">Pasta</th>
                    <th scope="col">Tipo de Ação</th>
                    <th scope="col">Ramo</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Comissão</th>
                    <th scope="col">Classificação Global (Valor Médio)</th>
                    <th scope="col">Classificação Global (Probabilidade)</th>
                    <th scope="col">Ir</th>
                </tr>
            </thead>
            <tbody >
                <?php foreach($data_tb as $row)
          
    {echo "<tr>";
        echo "<td>".$row['id_pasta']."</td>";
        echo "<td>".$row['tipo_acao']."</td>";
        echo "<td>".$row['ramo']."</td>";
        echo "<td>".$row['global_rating']."</td>";
        echo "<td>R$ ".number_format($row['global_comissao'],2,",",".")."</td>";
        echo "<td>R$ ".number_format($row['cg_vm'],2,",",".")."</td>";
        echo "<td>".$row['global_mde']."</td>";
        echo "<td>
        <a class='btn btn-sm btn-primary ' href='sistema.php?id_pasta=$row[id_pasta]' name='id_pasta' title='Ver Pasta'>
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-right-square' viewBox='0 0 16 16'>
            <path fill-rule='evenodd' d='M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5.854 8.803a.5.5 0 1 1-.708-.707L9.243 6H6.475a.5.5 0 1 1 0-1h3.975a.5.5 0 0 1 .5.5v3.975a.5.5 0 1 1-1 0V6.707l-4.096 4.096z'/>
        </svg>
        </a> 
        </td>";

    }
                    
                ?>
            </tbody>
        </table>
    </div>

     

    <br><br><br><br>

</body>
</html>
<script>
document.getElementById('downloadExcel').addEventListener('click',function(){
    var table2excel = new Table2Excel();
    table2excel.export(document.querySelectorAll("#tabelaResumo"));
});
</script>
<script>
function goBack() {
  window.history.back();
}
</script>