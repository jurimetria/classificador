<?php
    session_start();
    include_once('config2.php');
    $tipoPedido = $_GET['tipo_pedido'];
    $pasta = $_GET['id_pasta'];

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
        
    }
    $pdo = conectar();

    $pedido = $pdo->query('SELECT * FROM view_05_pedidos_graf  
    WHERE (id_pasta=\''.$pasta.'\' AND tipo_pedido=\''.$tipoPedido.'\')')->fetchAll();

    # print_r($pedido);



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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>


<body>
<!-- BARRA DE NAVEGAÇÃO -->
<?php echo $navBarClean ?>


    <!-- TITULO -->
        <h1>Gráfico do pedido <?php echo $tipoPedido ?></h1>
        <h3>Pasta:  <?php echo $pasta ?></h3>

    <!-- BOTOES -->
        <div class="alignLeft">
                <!-- BOTÃO VOLTAR -->
                <div class=' alignTop'>
                    <button class='button2' onclick="goBack()">Voltar</button>
                </div><br>

                
                <!-- LINK PÁGINA RESUMO -->
                <button type="button" class="button" onclick="location.href='resumo.php'">Ir para Resumo</button>
                <br><br>

                <!-- LINK PÁGINA GRAFICOS -->
                <button type="button" class="button" onclick="location.href='graficos.php'">Ir para a Página de Gráficos</button>
                <br>
        </div><br><br>
    

<div class='row'>
<canvas class='column side2 'id="myChartPie" style="width:1000px;max-width:1000px"></canvas>

<canvas class='column side2 ' id="myChartLine" style="width:1000px;max-width:1000px"></canvas>


  </div>
  <br><br><br><br><br><br><br><br>
</body>



<script>
var xValues = ["Inicial", "Primeira Instância", "Segunda Instância", "Decisão Final", "Acordos"];
var yValues = [55, 49, 44, 24, 15];
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("myChartPie", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Processos"
    }
  }
});
</script>

<script>
var xValues = [50,60,70,80,90,100,110,120,130,140,150];
var yValues = [7,8,8,9,9,9,10,11,14,14,15];

new Chart("myChartLine", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      fill: false,
      lineTension: 0,
      backgroundColor: "rgba(0,0,255,1.0)",
      borderColor: "rgba(0,0,0,0.1)",
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{ticks: {min: 6, max:16}}],
    }
  }
});
</script>

<script>
    function goBack() {
    window.history.back();
    }
</script>