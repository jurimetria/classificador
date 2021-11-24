<?php
    session_start();

    include('config2.php');
    $pdo = conectar();
   

    $id_pasta = $_GET['id_pasta'];


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
        $sum_val_rel_total = $pdo->prepare('SELECT SUM(valor_pedido*prob_med) AS valor FROM tb_dados_valores v INNER JOIN tb_probabilidade p
        ON v.probabilidade=p.probabilidade WHERE id_pasta=\''.$id_pasta.'\'');
        $sum_val_rel_total->execute();
        $sum_val_rel_total_return = $sum_val_rel_total->fetch(PDO::FETCH_ASSOC);

        // CLASSIFICAÇÃO DA AÇÃO
        $result_selection_rating_val_rel = $pdo->prepare('SELECT rating AS valor FROM tb_ratings WHERE (val_max>='.$sum_val_rel_total_return['valor'].' AND val_min<='.$sum_val_rel_total_return['valor'].')');
        $result_selection_rating_val_rel->execute();
        $result_selection_rating_val_rel_return = $result_selection_rating_val_rel->fetch(PDO::FETCH_ASSOC);
        // COMISSAO A SER PAGA
        $result_selection_comiss_val_rel = $pdo->prepare('SELECT comissao AS valor FROM tb_ratings WHERE (val_max>='.$sum_val_rel_total_return['valor'].' AND val_min<='.$sum_val_rel_total_return['valor'].')');
        $result_selection_comiss_val_rel->execute();
        $result_selection_comiss_val_rel_return = $result_selection_comiss_val_rel->fetch(PDO::FETCH_ASSOC);
        
        // PROBABILIDADE MEDIA DA PASTA
        $sum_val_rel_con_med = $pdo->prepare('SELECT AVG(prob_med) AS valor FROM tb_dados_valores v INNER JOIN tb_probabilidade p ON v.probabilidade=p.probabilidade WHERE id_pasta=\''.$id_pasta.'\'');
        $sum_val_rel_con_med->execute();
        $sum_val_rel_con_med_return = $sum_val_rel_con_med->fetch(PDO::FETCH_ASSOC);
        // print_r($sum_val_rel_con_med_return['valor']);

        // PRBABILIDADE  TXT
        $sum_val_rel_con_med_v2 = $pdo->prepare('SELECT prob_txt AS valor FROM tb_probabilidade WHERE (prob_max>='.$sum_val_rel_con_med_return['valor'].' AND prob_min<='.$sum_val_rel_con_med_return['valor'].')');
        $sum_val_rel_con_med_v2->execute();
        $sum_val_rel_con_med_v2_return = $sum_val_rel_con_med_v2->fetch(PDO::FETCH_ASSOC);
        
        // PRBABILIDADE MEDIA DA PASTA -  PROB
        $sum_val_rel_con_med_v3 = $pdo->prepare('SELECT probabilidade AS valor FROM tb_probabilidade WHERE (prob_max>='.$sum_val_rel_con_med_return['valor'].' AND prob_min<='.$sum_val_rel_con_med_return['valor'].')');
        $sum_val_rel_con_med_v3->execute();
        $sum_val_rel_con_med_v3_return = $sum_val_rel_con_med_v3->fetch(PDO::FETCH_ASSOC);
        
        // CRIA A VARIAVEL = CLASSIFICAÇÃO GLOBAL (Visão gerencial)
        $cgvg = $sum_val_rel_con_med_v3_return['valor'].': '.$sum_val_rel_con_med_v2_return['valor'];
    }
    
    ?>

    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>L&P | CLassificador OK</title>
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

        <?php
            echo "<h2>Pasta: $id_pasta</h2>";
        ?>
 
    </div>
<br>

    <!-- LINK PÁGINA RESUMO -->
    <div class="alingLeft">
        <button type="button" class="button button2" onclick="location.href='resumo.php'">Ir para Resumo</button>
    </div>
    <br>

    <!-- BUSCAR PASTA SEARCH BOX -->
    <div  class="buscar">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <form class="example" action="buscarPasta.php" method="GET">
                <input type="text" name="search" placeholder="buscar pasta...">
                <button type="submit" name="submit-search"><i class="fa fa-search"></i></button>
            </form>
    </div>
<br>
    <!-- TABELAS CENTRAIS -->
    <div class="row">
        <!-- TABELA DETALHES -->
        <div class="column side" >
            <h3>Dados da Pasta</h3>
            <?php echo "<b>Avaliador: </b>", $db_f['avaliador'];?><br>
            <?php echo "<b>Área: </b>", $db_f['area'];?><br>
            <?php echo "<b>Mês Avaliado: </b>", $db_f['mes_aval'];?><br>
            <?php echo "<b>Ano Avaliado: </b>", $db_f['ano_aval'];?><br>
            <?php echo "<b>Reclamante: </b>", $db_f['reclamante'];?><br>
            <?php echo "<b>Reclamada: </b>", $db_f['reclamada'];?><br>
            <?php echo "<b>Ramo: </b>", $db_f['ramo'];?><br>
            <?php echo "<b>Cargo: </b>", $db_f['cargo'];?><br>
            <?php echo "<b>Período Discutido: </b>", $db_f['periodo'];?><br>
            <?php echo "<b>Comarca: </b>", $db_f['comarca'];?><br>
            <?php echo "<b>Última Remuneração: </b>", $db_f['salario'];?><br>
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
        <h3>Classificação Global</h3>
            <?php echo "<b>Valor Global: </b>", $sum_val_rel_total_return['valor'];?><br><br>
            <?php echo "<b>Classificação Global (Probabilidade): </b>", $cgvg;?><br><br>
            <?php echo "<b>Classificação Relacionamento - Rating da Pasta: </b>", $result_selection_rating_val_rel_return['valor'];?><br><br>
            <?php echo "<b>Comissão a ser paga: </b>", $result_selection_comiss_val_rel_return['valor'];?><br>
        </div>

    </div>
   
       
    <!-- TABELA PEDIDOS -->
    <div class="m-5">
        <table class="table text-white table-bg">
            <thead>
                <tr>
                    <th scope="col">N° Registro</th>
                    <th scope="col">Tipo de Pedido</th>
                    <th scope="col">Valor Estimado do Pedido</th>
                    <th scope="col">Probabilidade de Êxito</th>
                    <th scope="col">Probabilidade Média</th>
                      <th scope="col">Valor Estimado com MDE %</th>
                    <th scope="col">...</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data_tb as $row) {
                        echo "<tr>";
                        echo "<td>".$row['n_registro']."</td>";
                        echo "<td>".$row['tipo_pedido']."</td>";
                        echo "<td class='myDIV'>".$row['valor_pedido']."</td>";
                        echo "<td>".$row['prob_txt']."</td>";
                        echo "<td>".$row['prob_med']."</td>";
                        echo "<td class='myDIV'>".$row['ValorEstimadocomMDE']."</td>";
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