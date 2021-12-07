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
        $state_prep = 'SELECT * FROM view_06_resumo WHERE (ano_aval=\''.$ano_aval.'\' AND mes_aval=\''.$mes_aval.'\') ';
        $teste = "1";
        

    } 
    else{$state_prep = 'SELECT * FROM view_06_resumo WHERE * GROUP BY f.id_pasta ';
        $teste = "0";
        $mes_aval = "";
        $ano_aval = "";

    }

    $state= $pdo->prepare($state_prep);
    $state->execute();
    $data_tb = $state->fetchAll();

    // SOMA VALOR TOTAL DE Classificação Global (Valor Médio)
    $sum_val_total_cme = $pdo->prepare('SELECT SUM(valor_global) AS valor  FROM view_06_resumo
    WHERE (ano_aval=\''.$ano_aval.'\' AND mes_aval=\''.$mes_aval.'\')  ;');
    $sum_val_total_cme->execute();
    $sum_val_total_cme_return = $sum_val_total_cme->fetch(PDO::FETCH_ASSOC);

    // SOMA VALOR TOTAL DE Comissao
    $sum_comissao = $pdo->prepare('SELECT SUM(comissao) AS valor FROM view_06_resumo
    WHERE (ano_aval=\''.$ano_aval.'\' AND mes_aval=\''.$mes_aval.'\')  ;');
    $sum_comissao->execute();
    $sum_comissao_return = $sum_comissao->fetch(PDO::FETCH_ASSOC);

   

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
    <!-- FAVICON -->
    <link rel="shortcut icon" href="https://lp-classificador.s3.amazonaws.com/img/favicon.ico" type="image/x-icon" />
    
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



    <!-- BOTÃO VOLTAR -->
    <div class='alingLeft alingTop'>
        <button class='button2' onclick="goBack()">Voltar</button>
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
            <button class="botaoFiltro2" id="downloadExcel">Exportar Tabela  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z"/>
                </svg><i class="bi bi-file-earmark-spreadsheet"></i>
            </button>
            

    </div>

    <!-- VALOR TOTAL -->
    <p id="fontSize19"><?php echo "Valor Total: R$ ",number_format($sum_val_total_cme_return['valor'],2,",",".") ?></p>

    <!-- COMISSAO TOTAL -->
    <p id="fontSize19"><?php echo "Comissão Total: R$ ",number_format($sum_comissao_return['valor'],2,",",".") ?></p>



 <!-- FILTRO MES E ANO --- CONSERTAR IDENTACAO -->
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
                        <button type="submit" name="enviar_busca" id="filter" class="botaoFiltro">Filtrar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                        </svg><i class="bi bi-funnel"></i></button>
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
                        echo "<td>".$row['rating']."</td>";
                        echo "<td>R$ ".number_format($row['comissao'],2,",",".")."</td>";
                        echo "<td>R$ ".number_format($row['valor_global'],2,",",".")."</td>";
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
    
    function goBack() {
        window.history.back();
    }
</script>