<?php
    session_start();

    include('config2.php');
    include('script.js');
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

        $data_res = $pdo->prepare('SELECT * FROM view_06_resumo  WHERE id_pasta=\''.$id_pasta.'\'');
        $data_res->execute();
        $data_resumo = $data_res->fetch(PDO::FETCH_ASSOC);
       
        $data_pedidos = $pdo->query('SELECT *, valor_pedido*prob_med as ValorEstimadocomMDE FROM tb_dados_valores v  
        INNER JOIN tb_probabilidade p
            ON v.probabilidade=p.probabilidade 
        WHERE id_pasta=\''.$id_pasta.'\'')->fetchAll();

        $count_pedidos = count($data_pedidos);

       

        if ($count_pedidos === 0)
        {
            $data_resumo['valor_global']=0;
            $data_resumo['global_mde']="Adicione Pedidos";
            $data_resumo['rating']="Adicione Pedidos";
            $data_resumo['honorarios_esp']=0;
            $data_resumo['comissao']=0;
            

        }
     
    }
        else
    {
        header('Location: index.php');
    }


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
        <!-- NÚMERO DA PASTA -->
        <?php
            echo "<h1>Pasta: $id_pasta</h1>";
        ?>

        <!-- LINK PÁGINA RESUMO -->
        <div class="alingLeft">
        <button type="button2" class="button" onclick="location.href='resumo.php'">Ir para Resumo</button>
        </div><br>


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
        </div>

<br>
    <!-- TABELAS CENTRAIS -->
    <div class="row">
        <!-- TABELA DETALHES -->
        <div class="column side" >
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
            <?php echo "<b>Porcentagem Honorários: </b>", $db_folder['honorarios_perc'],"%";?><br>
            
            <?php echo "<b>Última Remuneração: </b>R$ ", number_format( $db_folder['salario'],2,",",".");?><br>
            <?php echo "<b>Tipo de Ação: </b>", $db_folder['tipo_acao'];?><br>
            <?php echo "<b>Obs: </b>", $db_folder['obs'];?><br><br>
            <?php echo "<a class='btn btn-sm btn-primary' href='editFolder.php?id_pasta=$db_folder[id_pasta]' title='Editar Pasta'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                    </svg>   Editar dados da Pasta
                </a>";?>
        </div>



        <!--     TABELA CLASSIFICACAO GLOBAL        -->
        <div  class="column side" >
            <h3>Classificação Global</h3><br>
            <?php echo "<b>Valor Global: </b>R$ ", number_format( $data_resumo['valor_global'],2,",",".");?><br><br>
            <?php echo "<b>Classificação Global (Probabilidade): </b>", $data_resumo['global_mde'];?><br><br>
            <?php echo "<b>Classificação Relacionamento - Rating da Pasta: </b>", $data_resumo['rating'];?><br><br>
            <?php echo "<b>Honorários Esperados: </b>R$ ", number_format( $data_resumo['honorarios_esp'],2,",",".");?><br><br>
            <?php if ($db_folder['binaria']==="Não") {echo "<b>Comissão: </b>R$ ", number_format( $data_resumo['comissao'],2,",",".");} else {echo "<b>Comissão: </b>R$ 300,00";}?><br>

        </div>

    </div>
   
       
    <!-- TABELA PEDIDOS -->
    <div class="m-5">
    <h3>Tabela de Pedidos</h3><br>
        <table class="table text-white table-bg">
            <thead>
                <tr>
                    <th scope="col">N° Registro</th>
                    <th scope="col">Tipo de Pedido</th>
                    <th scope="col">Valor Estimado do Pedido</th>
                    <th scope="col">Probabilidade de Êxito</th>
                    <th scope="col">Faixa de Êxito</th>
                      <th scope="col">Valor com Média Êxito</th>
                    <th scope="col">...</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data_pedidos as $row) {
                        echo "<tr>";
                        echo "<td>".$row['n_registro']."</td>";
                        echo "<td>".$row['tipo_pedido']."</td>";
                        echo "<td>R$ ".number_format($row['valor_pedido'],2,",",".")."</td>";
                        echo "<td>".$row['probabilidade']."</td>";
                        echo "<td>".$row['prob_txt']."</td>";
                        echo "<td>R$ ".number_format($row['ValorEstimadocomMDE'],2,",",".")."</td>";
                        echo "<td>
                            <a class='btn btn-sm btn-primary' href='editPedido.php?n_registro=$row[n_registro]' name='n_registro2' title='Editar Pedido'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                            </svg>
                            </a> 
                            <a class='btn btn-sm btn-danger' href='delete.php?n_registro=$row[n_registro]' title='Cuidado! Não é possível recuperar o dado apagado'>
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

         <!-- BOTAO ADICIONAR PEDIDO -->
    <div>
        <?php
                
                echo "
                <a class='btn btn-sm btn-primary' href='adicionarPedido.php?id_pasta=$db_folder[id_pasta]' title='Adicionar Pedido'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                    </svg> Adicionar Pedido
                </a>";
            
        ?>
        
    </div>
    <br><br><br><br>
    
   
</body>
</html>