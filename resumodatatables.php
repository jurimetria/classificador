<?php

    session_start();

    include('config2.php');
    $pdo = conectar();

 
    $ano_aval = '';
    $query = "SELECT DISTINCT ano_aval FROM
      tb_folder  ORDER BY idtb_folder DESC";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
    $ano_aval .= '<option value="'.$row['ano_aval'].'">'.$row['ano_aval'].'</option>';
    }

    $mes_aval = '';
    $query = "SELECT DISTINCT mes_aval FROM tb_folder 
        ORDER BY mes_aval_n ASC";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
    $mes_aval .= '<option value="'.$row['mes_aval'].'">'.$row['mes_aval'].'</option>';
    }




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
        .ui-datepicker-calendar {
    display: none;
    
    }
    </style>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

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
        <!-- TITULO DA PAGINA -->
        <h1>Resumo das Classificações</h1>
        <!-- BUSCAR PASTA SEARCH BOX -->
        <div  class="buscar column">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <form class="example" action="buscarPasta.php" method="GET">
                <input type="text" name="search" placeholder="buscar pasta...">
                <button type="submit" name="submit-search"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <br>
        <div class="8">
            <p>Valor Relativo do Mês:</p>
            <p>Comissão total do Mês Selecionado:</p>
        </div>
    </div>
    <br>




    <!-- TABELA PEDIDOS -->
    
    <div class="container box">
        <div class="row">
            <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="filter_mes_aval" id="filter_mes_aval" class="form-control"  required>
                            <option value="">Selecione o Mês</option>
                            <?php echo $mes_aval; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="filter_ano_aval" id="filter_ano_aval" class="form-control" required>
                            <option value="">Selecione o Ano</option>
                            <?php echo $ano_aval; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="button" name="filter" id="filter" class="btn btn-info">Filtrar</button>
                    </div>

                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="table-responsive">
                <table id="customer_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="20%">Pasta</th>
                            <th width="10%">Tipo de Ação</th>
                            <th width="25%">Classificação Relacionamento - Rating da Pasta</th>
                            <th width="15%">Comissão</th>
                            <th width="15%">Classificação Global (Valor Médio)</th>
                            <th width="15%">Classificação Global (Probabilidade)</th> 
                        </tr>
                    </thead>
                </table>

            </div>
        </div>

    </div>
</body>
</html>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
  
  fill_datatable();
  
  function fill_datatable(filter_mes_aval = '', filter_ano_aval = '')
  {
   var dataTable = $('#customer_data').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "searching" : false,
    "ajax" : {
     url:"fetch.php",
     type:"POST",
     data:{
        filter_mes_aval:filter_mes_aval, filter_ano_aval:filter_ano_aval
     }
    }
   });
  }
  
  $('#filter').click(function(){
   var filter_mes_aval = $('#filter_mes_aval').val();
   var filter_ano_aval = $('#filter_ano_aval').val();
   if(filter_mes_aval != '' && filter_ano_aval != '')
   {
    $('#customer_data').DataTable().destroy();
    fill_datatable(filter_mes_aval, filter_ano_aval);
   }
   else
   {
    alert('Selecione ambos os filtros');
    $('#customer_data').DataTable().destroy();
    fill_datatable();
   }
  });
  
  
 });
 
</script>

