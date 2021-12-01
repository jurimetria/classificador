<?php
    session_start();

    include('config2.php');
    
    include('script.js');
    $pdo = conectar();
   
    if(!empty($id_pasta = $_GET['id_pasta']))
    {
        


        $stmt_vp = $pdo->prepare('SELECT * FROM tb_dados_valores v  
        INNER JOIN tb_probabilidade p
            ON v.probabilidade=p.probabilidade 
        WHERE id_pasta=\''.$id_pasta.'\'');
        $stmt_vp->execute(array('id_pasta' => $id_pasta));
        $db_vp =$stmt_vp->fetch(PDO::FETCH_ASSOC);

        $stmt_f = $pdo->prepare('SELECT * FROM tb_folder f  
        WHERE id_pasta=\''.$id_pasta.'\'');
        $stmt_f->execute(array('id_pasta' => $id_pasta));
        $db_f = $stmt_f->fetch(PDO::FETCH_ASSOC);

        $data_tb = $pdo->query('SELECT *, valor_pedido*prob_med as ValorEstimadocomMDE FROM tb_dados_valores v  
        INNER JOIN tb_probabilidade p
            ON v.probabilidade=p.probabilidade 
        WHERE id_pasta=\''.$id_pasta.'\'')->fetchAll();



        $count = count($data_tb);

        // print_r('Linhas: '.$count);

        if ($count === 0)
        {
            $sum_val_rel_total_return['valor']= "0";
            $sum_val_rel_considerado_return['valor'] = "0";
            $cgvg="Adicione Pedidos";
            $result_selection_rating_val_rel_return['valor']="Adicione Pedidos";
            $result_selection_comiss_val_rel_return['valor']="0";

        }
        else
        {

            
            // CLASSIFICAÇÃO GLOBAL - VARIÁVEIS
            // VALOR TOTAL 
            $sum_val_total = $pdo->prepare('SELECT SUM(valor_pedido) AS valor FROM tb_dados_valores v INNER JOIN tb_probabilidade p
            ON v.probabilidade=p.probabilidade WHERE id_pasta=\''.$id_pasta.'\'');
            $sum_val_total->execute();
            $sum_val_total_return = $sum_val_total->fetch(PDO::FETCH_ASSOC);

            // VALOR TOTAL COM MÉDIA DE EXITO
            $sum_val_total_cme = $pdo->prepare('SELECT SUM(valor_pedido*prob_med) AS valor FROM tb_dados_valores v INNER JOIN tb_probabilidade p
            ON v.probabilidade=p.probabilidade WHERE id_pasta=\''.$id_pasta.'\'');
            $sum_val_total_cme->execute();
            $sum_val_total_cme_return = $sum_val_total_cme->fetch(PDO::FETCH_ASSOC);

            // MÉDIA DE EXITO GLOBAL
            $med_exito = $sum_val_total_cme_return['valor']/ $sum_val_total_return['valor'];

            // PRBABILIDADE % (ALTA,BX,etc)
            $prob_perc = $pdo->prepare('SELECT probabilidade AS valor FROM tb_probabilidade WHERE (prob_max>='.$med_exito.' AND prob_min<='.$med_exito.')');
            $prob_perc->execute();
            $prob_perc_return = $prob_perc->fetch(PDO::FETCH_ASSOC);

            // PRBABILIDADE  TXT
            $prob_txt = $pdo->prepare('SELECT prob_txt AS valor FROM tb_probabilidade WHERE (prob_max>='.$med_exito.' AND prob_min<='.$med_exito.')');
            $prob_txt->execute();
            $prob_txt_return = $prob_txt->fetch(PDO::FETCH_ASSOC);

            // CRIA A VARIAVEL = CLASSIFICAÇÃO GLOBAL (Visão gerencial)
            $cgvg = $prob_perc_return['valor'].': '.$prob_txt_return['valor'];

            // Classificação Relacionamento - Rating da Pasta
            $pasta_rating = $pdo->prepare('SELECT rating AS valor FROM tb_ratings WHERE (val_max>='.$sum_val_total_cme_return['valor'].' AND val_min<='.$sum_val_total_cme_return['valor'].')');
            $pasta_rating->execute();
            $pasta_rating_return = $pasta_rating->fetch(PDO::FETCH_ASSOC);

            // COMISSAO A SER PAGA
            $comiss = $pdo->prepare('SELECT comissao AS valor FROM tb_ratings WHERE (val_max>='.$sum_val_total_cme_return['valor'].' AND val_min<='.$sum_val_total_cme_return['valor'].')');
            $comiss->execute();
            $comiss_return = $comiss->fetch(PDO::FETCH_ASSOC);

        }

    }
 else {
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
            <?php echo "<b>Avaliador: </b>", $db_f['avaliador'];?><br>
            <?php echo "<b>Área: </b>", $db_f['area'];?><br>
            <?php echo "<b>Mês Avaliado: </b>", $db_f['mes_aval'];?><br>
            <?php echo "<b>Ano Avaliado: </b>", $db_f['ano_aval'];?><br>
            <?php echo "<b>Reclamante: </b>", $db_f['reclamante'];?><br>
            <?php echo "<b>Reclamada: </b>", $db_f['reclamada'];?><br>
            <?php echo "<b>Ramo: </b>", $db_f['ramo'];?><br>
            <?php echo "<b>É binária: </b>", $db_f['binaria'];?><br>
            <?php echo "<b>Cargo: </b>", $db_f['cargo'];?><br>
            <?php echo "<b>Período Discutido: </b>", $db_f['periodo'];?><br>
            <?php echo "<b>Comarca: </b>", $db_f['comarca'];?><br>
            <?php echo "<b>Última Remuneração: </b>R$ ", number_format( $db_f['salario'],2,",",".");?><br>
            <?php echo "<b>Tipo de Ação: </b>", $db_f['tipo_acao'];?><br>
            <?php echo "<b>Obs: </b>", $db_f['obs'];?><br><br>
            <?php echo "<a class='btn btn-sm btn-primary' href='editFolder.php?id_pasta=$db_f[id_pasta]' title='Editar Pasta'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                    </svg>   Editar dados da Pasta
                </a>";?>
        </div>



        <!--     TABELA CLASSIFICACAO RELATIVA        -->
        <div  class="column side" >
            <h3>Classificação Global</h3><br>
            <?php echo "<b>Valor Global: </b>R$ ", number_format( $sum_val_total_cme_return['valor'],2,",",".");?><br><br>
            <?php echo "<b>Classificação Global (Probabilidade): </b>", $cgvg;?><br><br>
            <?php echo "<b>Classificação Relacionamento - Rating da Pasta: </b>", $pasta_rating_return['valor'];?><br><br>
            <?php if ($db_f['binaria']==="Não") {echo "<b>Comissão: </b>R$ ", number_format( $comiss_return['valor'],2,",",".");} else {echo "<b>Comissão a ser paga: </b>R$ 300,00";}?><br>

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
                <?php foreach($data_tb as $row) {
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
                <a class='btn btn-sm btn-primary' href='adicionarPedido.php?id_pasta=$db_f[id_pasta]' title='Adicionar Pedido'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                    </svg> Adicionar Pedido
                </a>";
            
        ?>
        
    </div>
    <br><br><br><br>
    
   
</body>
</html>