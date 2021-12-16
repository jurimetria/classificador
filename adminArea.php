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

    $data_tb_prob = $pdo->query('SELECT * FROM tb_probabilidade')->fetchAll();
    $data_tb_campos = $pdo->query('SELECT * FROM tb_campos')->fetchAll();
    $data_tb_rating = $pdo->query('SELECT * FROM tb_ratings')->fetchAll();
   
    $data_tb_folder = $pdo->query('SELECT * FROM tb_folder WHERE folderDel="SIM"')->fetchAll();

    // Salva dados da última alteração
    $logado = $_SESSION['email'];
    date_default_timezone_set('America/Sao_Paulo');
    $horario = date('m/d/Y h:i:s a', time());

    include('script.js');
    include('style.css');
    include('navbar.css');


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>L&P | CLassificador</title>
    
</head>

<body>
     <!-- BARRA DE NAVEGAÇÃO -->
     <?php echo $navBar ?><br>

    <!-- PASTAS COM PEDIDO DE EXCLUSÃO -->
    <div class="m-5">
        <h3>Pedidos de Exclusão</h3><br>
        <table class="table text-white table-bg">
            <thead>
                <tr>
                
                    <th scope="col">Pasta</th>

                  
                </tr>
            </thead>
            
            <tbody>
                <?php foreach($data_tb_folder as $row) {
                        echo "<tr>";
                        echo "<td>".$row['id_pasta']."</td>";

                        echo "</tr>";}
                    
                ?>
            </tbody>
        </table>
    </div>

    <!-- TABELA DOS CAMPOS -->  
    <div class="m-5">
        <h3>Tabela de Campos</h3><br>
        <table class="table text-white table-bg">
            <thead>
                <tr>
                
                    <th scope="col">Avaliador (texto)</th>
                    <th scope="col">Area (texto)</th>
                    <th scope="col">Tipo Acao (texto)</th>
                    <th scope="col">Tipo Pedido (texto)</th>
                    <th scope="col">Ano (INT)</th>
                    <th scope="col">Unidade (texto)</th>

                  
                </tr>
            </thead>
            
            <tbody>
                <?php foreach($data_tb_campos as $row) {
                        echo "<tr>";
                        echo "<td>".$row['avaliador']."</td>";
                        echo "<td>".$row['area']."</td>";
                        echo "<td>".$row['tipo_acao']."</td>";
                        echo "<td>".$row['tipo_pedido']."</td>";
                        echo "<td>".$row['ano']."</td>";
                        echo "<td>".$row['unidade']."</td>";
        
                        echo "</tr>";}
                    
                ?>
            </tbody>
        </table>
    </div>


    <!-- TABELA PROBALILIDADES -->  
    <div class="m-5">
        <h3>Tabela de Probabilidades</h3><br>
        <table class="table text-white table-bg">
            <thead>
                <tr>
                
                    <th scope="col">Probabilidade (texto)</th>
                    <th scope="col">Prob Descrição (texto)</th>
                    <th scope="col">Prob % (texto)</th>
                    <th scope="col">Prob Considerado (texto)</th>
                    <th scope="col">Prob Média (texto)</th>
                    <th scope="col">Prob Máx (texto)</th>
                    <th scope="col">Prob Min (texto)</th>
                  
                </tr>
            </thead>
            
            <tbody>
                <?php foreach($data_tb_prob as $row) {
                        echo "<tr>";
                        echo "<td>".$row['probabilidade']."</td>";
                        echo "<td>".$row['prob_txt']."</td>";
                        echo "<td>".$row['prob_perc']."</td>";
                        echo "<td>".$row['prob_considerado']."</td>";
                        echo "<td>".$row['prob_med']."</td>";
                        echo "<td>".$row['prob_max']."</td>";
                        echo "<td>".$row['prob_min']."</td>";
                        echo "</tr>";}
                    
                ?>
            </tbody>
        </table>
    </div>


    <!-- TABELA RATINGS -->
    <div class="m-5">
        <h3>Tabela de Ratings</h3><br>
        <table class="table text-white table-bg">
            <thead>
                <tr>
                
                    <th scope="col">rating (texto)</th>
                    <th scope="col">Expectativa de ganho (texto)</th>
                    <th scope="col">Comissão (Número)</th>
                    <th scope="col">Valor Máximo (Número)</th>
                    <th scope="col">Valor Mínimo (Número)</th>
                  
                </tr>
            </thead>

            <tbody>
                <?php foreach($data_tb_rating as $row) {
                        echo "<tr>";
                        echo "<td>".$row['rating']."</td>";
                        echo "<td>".$row['expectativa_ganho']."</td>";
                        echo "<td>".number_format($row['comissao'],2,",",".")."</td>";
                        echo "<td>".number_format($row['val_max'],2,",",".")."</td>";
                        echo "<td>R$ ".number_format($row['val_min'],2,",",".")."</td>";
                        echo "</tr>";}
                    
                ?>
            </tbody>
        </table>
    </div>








</body>
</html>

<script>
    function goBack() {
    window.history.back();
    }
</script>