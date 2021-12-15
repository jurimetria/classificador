<?php
    session_start();

    include('config2.php');
    
    $pdo = conectar();
   
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
  
    if(!empty($id_pasta = $_GET['id_pasta']))
    {

        $stmt_folder = $pdo->prepare('SELECT * FROM tb_folder  
        WHERE id_pasta=\''.$id_pasta.'\'');
        $stmt_folder->execute(array('id_pasta' => $id_pasta));
        $db_folder = $stmt_folder->fetch(PDO::FETCH_ASSOC);

        $data_res = $pdo->prepare('SELECT * FROM view_03_cme_3  WHERE id_pasta=\''.$id_pasta.'\'');
        $data_res->execute();
        $data_resumo_cme = $data_res->fetch(PDO::FETCH_ASSOC);

        $data_res_rel = $pdo->prepare('SELECT * FROM view_02_rel_2  WHERE id_pasta=\''.$id_pasta.'\'');
        $data_res_rel->execute();
        $data_resumo_rel = $data_res_rel->fetch(PDO::FETCH_ASSOC);
       
        $data_pedidos = $pdo->query('SELECT *, valor_pedido*prob_med as ValorEstimadocomMDE FROM tb_dados_valores v  
        INNER JOIN tb_probabilidade p
            ON v.probabilidade=p.probabilidade 
        WHERE id_pasta=\''.$id_pasta.'\'')->fetchAll();
    
        $count_pedidos = count($data_pedidos);

        $data_pedidos_aval_inicial = $pdo->query('SELECT *, valor_pedido*prob_med as ValorEstimadocomMDE FROM tb_dados_valores v  
        INNER JOIN tb_probabilidade p
            ON v.probabilidade=p.probabilidade 
        WHERE (id_pasta=\''.$id_pasta.'\' AND tipo_avaliacao="INICIAL")')->fetchAll();

        $data_pedidos_aval_primeiro = $pdo->query('SELECT *, valor_pedido*prob_med as ValorEstimadocomMDE FROM tb_dados_valores v  
        INNER JOIN tb_probabilidade p
            ON v.probabilidade=p.probabilidade 
        WHERE (id_pasta=\''.$id_pasta.'\' AND tipo_avaliacao="DECISAO PRIMEIRO GRAU")')->fetchAll();

        $data_pedidos_aval_segundo = $pdo->query('SELECT *, valor_pedido*prob_med as ValorEstimadocomMDE FROM tb_dados_valores v  
        INNER JOIN tb_probabilidade p
            ON v.probabilidade=p.probabilidade 
        WHERE (id_pasta=\''.$id_pasta.'\' AND tipo_avaliacao="DECISAO SEGUNDO GRAU")')->fetchAll();
                
        $data_pedidos_aval_liquidacao = $pdo->query('SELECT *, valor_pedido*prob_med as ValorEstimadocomMDE FROM tb_dados_valores v  
        INNER JOIN tb_probabilidade p
            ON v.probabilidade=p.probabilidade 
        WHERE (id_pasta=\''.$id_pasta.'\' AND tipo_avaliacao="LIQUIDACAO FINAL")')->fetchAll();
       

       $data_pedidos_aval_acordo = $pdo->query('SELECT *, valor_pedido*prob_med as ValorEstimadocomMDE FROM tb_dados_valores v  
        INNER JOIN tb_probabilidade p
            ON v.probabilidade=p.probabilidade 
        WHERE (id_pasta=\''.$id_pasta.'\' AND tipo_avaliacao="ACORDO")')->fetchAll();



        if ($count_pedidos === 0)
        {
            $data_resumo_rel['valor_global']=0;
            $data_resumo_cme['global_mde']="Adicione Pedidos";
            $data_resumo_rel['rating']="Adicione Pedidos";
            $data_resumo_cme['honorarios_esp']=0;
            $data_resumo_rel['comissao']=0;
            $data_resumo_cme['valor_cme']=0;
            $data_resumo_cme['honorarios_perc']=0;
            

        }
     
    }
        else
    {
        header('Location: index.php');
    }


    $emExclusao="";
    $emExclusao2="";
    $emExclusao3="";
    if($db_folder['folderDel']==='SIM'){
        $emExclusao = "<br> PASTA EM PROCESSO DE EXCLUSÃO";
        $emExclusao2 = "Todo o seu conteúdo e pedidos serão apagados";
        $emExclusao3 = "Para reverter este procedimento entre em contato com o Administrador";
    } 


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



    <!-- SAIR -->
    <div class="d-flex">
        <a href="login.php" class="btn btn-danger me-5">Sair</a>
    </div>
</nav>
</div>  

<br>
        <!-- NÚMERO DA PASTA -->
        <?php
            echo "<h1>Pasta: $id_pasta</h1>";
        ?>

        <!-- PASTA EM EXCLUSÃO -->
        <?php
            echo "<h1 class='text-danger'>$emExclusao</h1>";
            echo "<h3 class='text-danger'>$emExclusao2</h3>";
            echo "<h3 class='text-danger'>$emExclusao3</h3>";
        ?>


        <!-- LINK PÁGINA RESUMO -->
        <div class="alignLeft">
        <button type="button2" class="button" onclick="location.href='resumo.php'">Ir para Resumo</button>
        </div><br>


        <!-- CADASTRAR NOVA PASTA -->
        <div class='alignLeft '>
        <a class="button2 " href="pastaNova.php">Cadastrar Nova Pasta</a>
        </div>
        <br>

        <!-- BUSCAR PASTA SEARCH BOX -->
        <div  class="buscar alignLeft">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <form class="searchF" action="pastaBuscar.php" method="GET">
        <input type="text" name="search" placeholder="buscar pasta...">
        <button type="submit" name="submit-search"><i class="fa fa-search"></i></button>
        </form>
        </div><br>

    
    <!-- TABELAS CENTRAIS -->
    <div class="row">
        <!-- TABELA DETALHES -->
        <div class="column side alignLeft" >
            <h3>Dados da Pasta</h3><br>
            <?php echo "<b>Avaliador: </b>", $db_folder['avaliador'];?><br>
            <?php echo "<b>Área: </b>", $db_folder['area'];?><br>
            <?php echo "<b>Unidade: </b>", $db_folder['unidade'];?><br>
            <?php echo "<b>Comarca: </b>", $db_folder['comarca'];?><br>
            <?php echo "<b>Mês Avaliado: </b>", $db_folder['mes_aval'];?><br>
            <?php echo "<b>Ano Avaliado: </b>", $db_folder['ano_aval'];?><br>
            <?php echo "<b>Reclamante: </b>", $db_folder['reclamante'];?><br>
            <?php echo "<b>Reclamada: </b>", $db_folder['reclamada'];?><br>
            <?php echo "<b>Ramo: </b>", $db_folder['ramo'];?><br>
            <?php echo "<b>É binária: </b>", $db_folder['binaria'];?><br>
            <?php echo "<b>Cargo: </b>", $db_folder['cargo'];?><br>
            <?php echo "<b>Período Discutido: </b>", $db_folder['periodo'];?><br>
            <?php echo "<b>Última Remuneração: </b>R$ ", number_format( $db_folder['salario'],2,",",".");?><br>
            <?php echo "<b>Tipo de Ação: </b>", $db_folder['tipo_acao'];?><br>
            <?php echo "<b>Obs: </b>", $db_folder['obs'];?><br><br>
            <?php echo "<a class='btn btn-sm btn-primary' href='pastaEdit.php?id_pasta=$db_folder[id_pasta]' title='Editar Pasta'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                    </svg>   Editar dados da Pasta
                </a>";?>
        </div>



        <!--     TABELAS DE CLASSIFICACAO        -->
        <div  class="column side alignLeft" >
            <!--     RELACIONAMENTO        -->
            <h3>Classificação Relacionamento</h3><br>
            <?php echo "<b>Valor: </b>R$ ", number_format( $data_resumo_rel['valor_global'],2,",",".");?><br>
            <?php echo "<b>Classificação da Ação: </b>", $data_resumo_rel['rating'];?><br>
            <?php if ($db_folder['binaria']==="Não") {echo "<b>Comissão: </b>R$ ", number_format( $data_resumo_rel['comissao'],2,",",".");} else {echo "<b>Comissão: </b>R$ 300,00";}?><br>
             <!--     GERENCIAL        -->
            <br><br><h3>Classificação Gerencial</h3><br>
            <?php echo "<b>Valor: </b>R$ ", number_format( $data_resumo_cme['valor_cme'],2,",",".");?><br>
            <?php echo "<b>Probabilidade: </b>", $data_resumo_cme['global_mde'];?><br>
            <?php echo "<b>Honorários %: </b>", $data_resumo_cme['honorarios_perc'],"%";?><br>
            <?php echo "<b>Honorários Esperados: </b>R$ ", number_format( $data_resumo_cme['honorarios_esp'],2,",",".");?><br>

        </div>
    </div>
    <br><br>
       
    <!-- TABELA PEDIDOS: INICIAL -->
        <?php $tabela_aval_inicial="
        <div class='m-5'>
        <h3>Pedidos em: Avaliação Inicial</h3><br>
            <table class='table text-white table-bg'>
                <thead>
                    <tr>
                        <th scope='col'>Tipo de Pedido</th>
                        <th scope='col'>Mês Avaliação</th>
                        <th scope='col'>Ano Avaliação</th>
                        
                        <th scope='col'>Valor Estimado do Pedido</th>
                        <th scope='col'>Probabilidade de Êxito</th>
                        <th scope='col'>Faixa de Êxito</th>
                        <th scope='col'>Valor com Média Êxito</th>
                        <th scope='col'>...</th>
                    </tr>
                </thead>"
        ?>
          
            <?php if(count($data_pedidos_aval_inicial) === 0) {} else {echo $tabela_aval_inicial;} ?>
            <tbody>
                <?php foreach($data_pedidos_aval_inicial as $row) {
                        echo "<tr>";
                        echo "<td>".$row['tipo_pedido']."</td>";
                        echo "<td>".$row['mes_avaliacao']."</td>";
                        echo "<td>".$row['ano_avaliacao']."</td>";
                        
                        echo "<td>R$ ".number_format($row['valor_pedido'],2,",",".")."</td>";
                        echo "<td>".$row['probabilidade']."</td>";
                        echo "<td>".$row['prob_txt']."</td>";
                        echo "<td>R$ ".number_format($row['ValorEstimadocomMDE'],2,",",".")."</td>";
                        echo "<td>
                            <a class='btn btn-sm btn-primary' href='pedidoEdit.php?n_registro=$row[n_registro]' name='n_registro2' title='Editar Pedido'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                            </svg>
                            </a> 
                            <a class='btn btn-sm btn-danger confirmation' href='pedidoDelete.php?n_registro=$row[n_registro]' title='Apagar o pedido permanentemente'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                </svg>
                            </a>
                            </td>";
                        echo "</tr>";}
                    
                ?>
            </tbody>
        </table>
    </div><br>

    <!-- TABELA PEDIDOS: DECISAO PRIMEIRO GRAU -->
        <?php $tabela_aval_primeiro="
            <div class='m-5'>
            <h3>Pedidos em: Decisão de Primeiro Grau</h3><br>
                <table class='table text-white table-bg'>
                    <thead>
                        <tr>
                            <th scope='col'>Tipo de Pedido</th>
                            <th scope='col'>Mês Avaliação</th>
                            <th scope='col'>Ano Avaliação</th>
                         
                            <th scope='col'>Valor Estimado do Pedido</th>
                            <th scope='col'>Probabilidade de Êxito</th>
                            <th scope='col'>Faixa de Êxito</th>
                            <th scope='col'>Valor com Média Êxito</th>
                            <th scope='col'>...</th>
                        </tr>
                    </thead>"
            ?>
         
            <?php if(count($data_pedidos_aval_primeiro) === 0) {} else {echo $tabela_aval_primeiro;} ?>
            <tbody>
                <?php foreach($data_pedidos_aval_primeiro as $row) {
                        echo "<tr>";
                        echo "<td>".$row['tipo_pedido']."</td>";
                        echo "<td>".$row['mes_avaliacao']."</td>";
                        echo "<td>".$row['ano_avaliacao']."</td>";
                        
                        echo "<td>R$ ".number_format($row['valor_pedido'],2,",",".")."</td>";
                        echo "<td>".$row['probabilidade']."</td>";
                        echo "<td>".$row['prob_txt']."</td>";
                        echo "<td>R$ ".number_format($row['ValorEstimadocomMDE'],2,",",".")."</td>";
                        echo "<td>
                            <a class='btn btn-sm btn-primary' href='pedidoEdit.php?n_registro=$row[n_registro]' name='n_registro2' title='Editar Pedido'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                            </svg>
                            </a> 
                            <a class='btn btn-sm btn-danger confirmation' href='pedidoDelete.php?n_registro=$row[n_registro]' title='Apagar o pedido permanentemente'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                </svg>
                            </a>
                            </td>";
                        echo "</tr>";}
                    
                ?>
            </tbody>
        </table>
    </div>
    <br>

    <!-- TABELA PEDIDOS: DECISAO SEGUNDO GRAU -->
        <?php $tabela_aval_segundo="
            <div class='m-5'>
            <h3>Pedidos em: Decisão de Segundo Grau</h3><br>
                <table class='table text-white table-bg'>
                    <thead>
                        <tr>
                            <th scope='col'>Tipo de Pedido</th>
                            <th scope='col'>Mês Avaliação</th>
                            <th scope='col'>Ano Avaliação</th>
                            
                            <th scope='col'>Valor Estimado do Pedido</th>
                            <th scope='col'>Probabilidade de Êxito</th>
                            <th scope='col'>Faixa de Êxito</th>
                            <th scope='col'>Valor com Média Êxito</th>
                            <th scope='col'>...</th>
                        </tr>
                    </thead>"
            ?>
           
            <?php if(count($data_pedidos_aval_segundo) === 0) {} else {echo $tabela_aval_segundo;} ?>
            <tbody>
                <?php foreach($data_pedidos_aval_segundo as $row) {
                        echo "<tr>";
                        echo "<td>".$row['tipo_pedido']."</td>";
                        echo "<td>".$row['mes_avaliacao']."</td>";
                        echo "<td>".$row['ano_avaliacao']."</td>";
                        
                        echo "<td>R$ ".number_format($row['valor_pedido'],2,",",".")."</td>";
                        echo "<td>".$row['probabilidade']."</td>";
                        echo "<td>".$row['prob_txt']."</td>";
                        echo "<td>R$ ".number_format($row['ValorEstimadocomMDE'],2,",",".")."</td>";
                        echo "<td>
                            <a class='btn btn-sm btn-primary' href='pedidoEdit.php?n_registro=$row[n_registro]' name='n_registro2' title='Editar Pedido'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                            </svg>
                            </a> 
                            <a class='btn btn-sm btn-danger confirmation' href='pedidoDelete.php?n_registro=$row[n_registro]' title='Apagar o pedido permanentemente'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                </svg>
                            </a>
                            </td>";
                        echo "</tr>";}
                    
                ?>
            </tbody>
        </table>
    </div>
    <br>
    <!-- TABELA PEDIDOS: LIQUIDACAO FINAL -->
        <?php $tabela_aval_liquidacao="
            <div class='m-5'>
            <h3>Pedidos em: Liquidação Final</h3><br>
                <table class='table text-white table-bg'>
                    <thead>
                        <tr>
                            <th scope='col'>Tipo de Pedido</th>
                            <th scope='col'>Mês Avaliação</th>
                            <th scope='col'>Ano Avaliação</th>
                            
                            <th scope='col'>Valor Estimado do Pedido</th>
                            <th scope='col'>Probabilidade de Êxito</th>
                            <th scope='col'>Faixa de Êxito</th>
                            <th scope='col'>Valor com Média Êxito</th>
                            <th scope='col'>...</th>
                        </tr>
                    </thead>"
            ?>
            <?php if(count($data_pedidos_aval_liquidacao) === 0) {} else {echo $tabela_aval_liquidacao;} ?>
            <tbody>
                <?php foreach($data_pedidos_aval_liquidacao as $row) {
                        echo "<tr>";
                        echo "<td>".$row['tipo_pedido']."</td>";
                        echo "<td>".$row['mes_avaliacao']."</td>";
                        echo "<td>".$row['ano_avaliacao']."</td>";
                        
                        echo "<td>R$ ".number_format($row['valor_pedido'],2,",",".")."</td>";
                        echo "<td>".$row['probabilidade']."</td>";
                        echo "<td>".$row['prob_txt']."</td>";
                        echo "<td>R$ ".number_format($row['ValorEstimadocomMDE'],2,",",".")."</td>";
                        echo "<td>
                            <a class='btn btn-sm btn-primary' href='pedidoEdit.php?n_registro=$row[n_registro]' name='n_registro2' title='Editar Pedido'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                            </svg>
                            </a> 
                            <a class='btn btn-sm btn-danger confirmation' href='pedidoDelete.php?n_registro=$row[n_registro]' title='Apagar o pedido permanentemente'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                </svg>
                            </a>
                            </td>";
                        echo "</tr>";}
                ?>
            </tbody>
        </table>


    </div>

        <!-- TABELA PEDIDOS: ACORDO -->
            <?php $tabela_aval_acordo="
            <div class='m-5'>
            <h3>Pedidos em: Acordo</h3><br>
                <table class='table text-white table-bg'>
                    <thead>
                        <tr>
                            <th scope='col'>Tipo de Pedido</th>
                            <th scope='col'>Mês Avaliação</th>
                            <th scope='col'>Ano Avaliação</th>
                            
                            <th scope='col'>Valor Estimado do Pedido</th>
                            <th scope='col'>Probabilidade de Êxito</th>
                            <th scope='col'>Faixa de Êxito</th>
                            <th scope='col'>Valor com Média Êxito</th>
                            <th scope='col'>...</th>
                        </tr>
                    </thead>"
            ?>
            <?php if(count($data_pedidos_aval_acordo) === 0) {} else {echo $tabela_aval_acordo;} ?>
            <tbody>
                <?php foreach($data_pedidos_aval_acordo as $row) {
                        echo "<tr>";
                        echo "<td>".$row['tipo_pedido']."</td>";
                        echo "<td>".$row['mes_avaliacao']."</td>";
                        echo "<td>".$row['ano_avaliacao']."</td>";
                        
                        echo "<td>R$ ".number_format($row['valor_pedido'],2,",",".")."</td>";
                        echo "<td>".$row['probabilidade']."</td>";
                        echo "<td>".$row['prob_txt']."</td>";
                        echo "<td>R$ ".number_format($row['ValorEstimadocomMDE'],2,",",".")."</td>";
                        echo "<td>
                            <a class='btn btn-sm btn-primary' href='pedidoEdit.php?n_registro=$row[n_registro]' name='n_registro2' title='Editar Pedido'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                            </svg>
                            </a> 
                            <a class='btn btn-sm btn-danger confirmation' href='pedidoDelete.php?n_registro=$row[n_registro]' title='Apagar o pedido permanentemente'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                </svg>
                            </a>
                            </td>";
                        echo "</tr>";}
                ?>
            </tbody>
        </table>


    </div>


    <!-- BOTÕES PEDIDOS FINAL-->
        <div class="row">
                    <!-- BOTAO ADICIONAR PEDIDO INICIAL-->
                
                <div class="column side">
            <?php
                    
                    echo "
                    <a class='btn btn-sm btn-primary' href='pedidoNovo.php?id_pasta=$db_folder[id_pasta]' title='Adicionar Pedido'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                            <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                        </svg> Adicionar Pedido Inicial
                    </a>";
            ?>
        </div>

         <!-- BOTAO ADICIONAR NOVA ETAPA-->
        <div class="column side">
        <?php
                
                echo "
                <a class='btn btn-sm btn-secondary' href='pedidoEtapaNova.php?id_pasta=$db_folder[id_pasta]' title='Adicionar Nova Etapa'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
              </svg>
               Adicionar Nova Etapa
                </a>";
        ?>
        </div>
    </div>
    <br><br><br><br>
    
   
</body>
</html>

<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Você deseja apagar o pedido permanentemente? (Não será possível recuperá-lo)')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>