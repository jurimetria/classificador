<?php
    session_start();

    include('config2.php');
    $pdo = conectar();

    $state_prep = '
    SELECT *
    ,SUM(valor_pedido*prob_med) as cg_vm
    ,IF(SUM(valor_pedido*prob_med)>=1000000, "AAA",
    IF((SUM(valor_pedido*prob_med)>=700000 AND SUM(valor_pedido*prob_med)<1000000), "AAB",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<700000), "ABB",
    IF((SUM(valor_pedido*prob_med)>=300000 AND SUM(valor_pedido*prob_med)<500000), "BBB",
    IF((SUM(valor_pedido*prob_med)>=200000 AND SUM(valor_pedido*prob_med)<300000), "BBC",
    IF((SUM(valor_pedido*prob_med)>=100000 AND SUM(valor_pedido*prob_med)<200000), "BCC",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<100000), "CCC",
    IF((SUM(valor_pedido*prob_med)<50000), "D",
    IF((SUM(valor_pedido*prob_med)=0), "E",
    "F"
    ))))))))) as global_rating
    
    ,IF(SUM(valor_pedido*prob_med)>=1000000, "R$ 1.000",
    IF((SUM(valor_pedido*prob_med)>=700000 AND SUM(valor_pedido*prob_med)<1000000), "R$ 850",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<700000), "R$ 700",
    IF((SUM(valor_pedido*prob_med)>=300000 AND SUM(valor_pedido*prob_med)<500000), "R$ 500",
    IF((SUM(valor_pedido*prob_med)>=200000 AND SUM(valor_pedido*prob_med)<300000), "R$ 400",
    IF((SUM(valor_pedido*prob_med)>=100000 AND SUM(valor_pedido*prob_med)<200000), "R$ 300",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<100000), "R$ 250",
    IF((SUM(valor_pedido*prob_med)<50000), 0,
    IF((SUM(valor_pedido*prob_med)=0), "R$ 0","R$ 300"
    ))))))))) as global_comissao
    
    ,IF(AVG(prob_med)>=0.9, "ALTA: 90%-100%",
    IF((AVG(prob_med)>=0.7 AND AVG(prob_med)<0.9), "PROVÁVEL: 70% a 90%",
    IF((AVG(prob_med)>=0.5 AND AVG(prob_med)<0.7),"POSSÍVEL: 50% a 70%",
    IF((AVG(prob_med)>=0.2 AND AVG(prob_med)<0.5), "BAIXA: 20% a 50%",
    IF((AVG(prob_med)<0.2), "REMOTA: abaixo de 20%",""
    ))))) as global_mde
    
    FROM tb_dados_valores v 
    INNER JOIN  tb_folder f ON v.id_pasta=f.id_pasta
    INNER JOIN tb_probabilidade p ON p.probabilidade=v.probabilidade

';
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


    if($mes_aval=""){}
    if($ano_aval=""){}
        $teste = "0";
 


    if (isset($_POST['enviar_busca']))
    {

        $mes_aval = $_POST['search_mes'];
        $ano_aval = $_POST['search_ano'];
        $state_prep .= 'WHERE (ano_aval=\''.$ano_aval.'\' AND mes_aval=\''.$mes_aval.'\') GROUP BY f.id_pasta ';
        $teste = "1";

    }
    $state= $pdo->prepare($state_prep);
    $state->execute();
    $data_tb = $state->fetchAll();

   
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
            font-size: 18px;
        }
        .table-bg{
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px 15px 0 0;
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

        .buscar{
            padding-left: 50px;
        }

        /* Style the search field */
        form.example input[type=text] {
        padding: 10px;
        font-size: 17px;
        border: none;
        float: left;
        width: 10%;
        background: #f1f1f1;
        height: 45px;
        border-radius: 5px 0px 0px 5px;
    
 
        

        }

        /* Style the submit button */
        form.example button {
        float: left;
        width: 5%;
        height: 45px;
        padding: 10px;
        background: dodgerblue;
        color: white;
        font-size: 17px;
        border: none;
        border-left: none; /* Prevent double borders */
        cursor: pointer;
        border-radius: 0px 5px 5px 0px;

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

        .pasta{
        padding-bottom: 30px;

        }
        /* Create three unequal columns that floats next to each other */
        .column {

        text-align: left;
        padding-left: 60px;
        
        }

        /* Left and right column */
        .column.side {
        width: 33%;
        
        }

        /* Clear floats after the columns */
        .row:after {
        content: "";
        display: table;
        clear: both;
        
        }

        /* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 400px) {
        .column.side{
            width: 100%;
            
        }
        }
        .currSign:before {
            content: 'R$ ';
        }
        .racon {
            color: #f0bc4a;
        }
        
        .button {
        border: none;
        padding: 8px 12px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 18px;
        margin: 2px 1px;
        transition-duration: 0.4s;
        cursor: pointer;
        border-radius: 5px;
        }



        .button2 {
        background-color: #f1f1f1; 
 
        border: 2px solid dodgerblue;
        }

        .button2:hover {
        background-color: dodgerblue;
        color: white;
        }

        .alingLeft {
            text-align: left;
            padding-left: 48px;
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


 
    </div>
<br>
    <!-- TITULO DA PAGINA -->
    <h1>Resumo das Classificações</h1>
    <!-- RESULTADOS DA FILTRAGEM -->
    <?php if ($teste="1"){echo "Resultados de "; echo $mes_aval; echo " de "; echo $ano_aval;} else{} ?>

    <!-- BUSCAR PASTA SEARCH BOX -->
    <div  class="buscar">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <form class="example" action="buscarPasta.php" method="GET">
                <input type="text" name="search" placeholder="buscar pasta...">
                <button type="submit" name="submit-search"><i class="fa fa-search"></i></button>
            </form>
    </div>
    <br>




 <!-- FILTRO MES E ANO -->
    <form name="search_form" action="resumo.php" method="POST"> 
        <select name="search_mes" id="search_mes"  required>
            <option value="">Selecione o Mês</option>
            <?php echo $ver_mes_aval; ?>
        </select>

        <select name="search_ano" id="search_ano"  required>
            <option value="">Selecione o Ano</option>
            <?php echo $ver_ano_aval; ?>
        </select>

    <button type="submit" name="enviar_busca" id="filter" class="btn btn-info">Filtrar</button>
    </form>




    <!-- TABELA PEDIDOS -->
    <div class="m-5">
        <table class="table text-white table-bg">
            <thead>
                <tr>
                    <th scope="col">Pasta</th>
                    <th scope="col">Tipo de Pedido</th>
                    <th scope="col">Classificação Relacionamento - Rating da Pasta</th>
                    <th scope="col">Comissão</th>
                    <th scope="col">Classificação Global (Valor Médio)</th>
                    <th scope="col">Classificação Global (Probabilidade)</th>
                    <th scope="col">Ir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data_tb as $row)
    {echo "<tr>";
        
        echo "<td>".$row['id_pasta']."</td>";
        echo "<td>".$row['tipo_acao']."</td>";
        echo "<td>".$row['global_rating']."</td>";
        echo "<td>".$row['global_comissao']."</td>";
        echo "<td class='myDIV'>".$row['cg_vm']."</td>";
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
    <!-- SCRIPT FORMATA CURRENCY -->
    <script>
        let x = document.querySelectorAll(".myDIV");
        for (let i = 0, len = x.length; i < len; i++) {
            let num = Number(x[i].innerHTML)
                      .toLocaleString('br');
            x[i].innerHTML = num;
            x[i].classList.add("currSign");
        }

        
</script>
</body>
</html>

