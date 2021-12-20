<?php
    session_start();
    include('config2.php');
    include('salvaDados.php');
    
    $pdo = conectar();
    

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }

    
    $id_pasta = $_GET['id_pasta'];

    # VER OPÇÕES DE SELEÇÃO
    # VER TIPO DE PEDIDO
    $ver_tipo_pedido = '';
    $query = "SELECT DISTINCT tipo_pedido FROM
        tb_campos WHERE tipo_pedido IS NOT NULL ";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach($result as $row)
    {
        $ver_tipo_pedido .= '<option value="'.$row['tipo_pedido'].'">'.$row['tipo_pedido'].'</option>';
    }
    
    if(!empty($_GET['id_pasta']))
    {
        include_once('config.php');
        
        $id_pasta = $_GET['id_pasta'];

        $sqlSelect = "SELECT * FROM tb_dados_valores WHERE id_pasta=$id_pasta";


        $result = $conexao->query($sqlSelect);

        
        
        if(isset($_POST["submit"]))
        {
            
            $logado = $_POST['logado'];
            $horario = $_POST['horario'];
            $id_pasta = $_POST['id_pasta'];
            $tipo_pedido = $_POST['tipo_pedido'];
            $valor_pedido = $_POST['valor_pedido'];
            $probabilidade = $_POST['probabilidade'];
            $tipo_avaliacao = $_POST['tipo_avaliacao'];
            $mes_avaliacao = $_POST['mes_avaliacao'];
            $ano_avaliacao = $_POST['ano_avaliacao'];
            $avaliador = $_POST['avaliador'];

            $result = mysqli_query($conexao, "INSERT INTO tb_dados_valores (logado, horario, id_pasta,tipo_pedido,valor_pedido,probabilidade,tipo_avaliacao,mes_avaliacao,ano_avaliacao,avaliador) 
            VALUES ('$logado','$horario','$id_pasta','$tipo_pedido','$valor_pedido','$probabilidade','$tipo_avaliacao','$mes_avaliacao','$ano_avaliacao','$avaliador')");

            {
                header('Location: sistema.php?id_pasta='.$id_pasta);
            }
        }
    }
    else
    {
        header('Location: index.php');
    }


    
    #print_r($logadoAvaliadorTipo);
    #print_r("<br>");
    #print_r($logadoAvaliador);

    # VER AVALIADOR
    if ($logadoAvaliadorTipo==='avaliador'){$query = "SELECT nome FROM tb_usuarios WHERE nome='$logadoAvaliador'"; }
    else {$query = "SELECT nome FROM tb_usuarios WHERE secGroup='avaliador' ORDER BY nome ASC ";}
    
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
   
    $ver_avaliador = '';
    foreach($result as $row)
    {
        $ver_avaliador .= '<option value="'.$row['nome'].'">'.$row['nome'].'</option>';
    }


    # VER ANO
        $ver_ano = '';
        $query = "SELECT DISTINCT ano FROM
            tb_campos WHERE ano <= $ano_atual ORDER BY ano DESC ";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        # IS NOT NULL ORDER BY ano DESC
        foreach($result as $row)
        {
            $ver_ano .= '<option value="'.$row['ano'].'">'.$row['ano'].'</option>';
        }
 
    
    // Completa com o mês atual na caixa menu mês
       $datam = date('m');
       $dataa = date('Y');



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
<body>
<!-- BARRA DE NAVEGAÇÃO -->
<?php echo $navBarClean ?>

    <!-- VOLTAR -->
    <div class='alignLeft alignTop'>
        <?php
            {echo "<a class='button2' href='sistema.php?id_pasta=$id_pasta' title='Voltar'> Voltar</a>";
            }
        ?>
    </div>


    <!-- CAIXA DE INPUTS -->
    <div class="box">
        <form action="" method="POST">
            <fieldset>
                <legend id='padding12'><a><b>Novo pedido Inicial - Pasta: <?php echo $id_pasta ?> </b></a></legend>
                <br><br>

                <div class="inputBox" class="container">
                    <label for="tipo_pedido">Pedido:</label>
                        <select name="tipo_pedido" id="tipo_pedido"  required>
                        <option value="" >Escolha...</option>
                            <?php echo $ver_tipo_pedido; ?>
                        </select>
                </div><br>

                <div class="inputBox" class="container">
                        <label for="avaliador">Avaliador:</label>
                                <select name="avaliador" id="avaliador"  required>
                                
                                    <?php echo $ver_avaliador; ?>
                                </select>
                            </div>
                        <br>

                
                <div class="inputBox">
                    <input type = "number" step="0.01" min="0" name="valor_pedido" id="valor_pedido" class="inputUser"  required>
                    <label for="valor_pedido" class="labelInput">Valor pedido</label>
                </div><br>
                
                <div class="inputBox" class="container">
                    <label for="probabilidade" >Probabilidade de Êxito: </label>
                    <select id="probabilidade" name="probabilidade">
                    
                        <option value="ALTA">Alta: 90% a 100%</option>
                        <option value="PROVÁVEL">Provável: 70% a 90%</option>
                        <option value="POSSÍVEL">Possível: 50% a 70%</option>
                        <option value="BAIXA">Baixa: 20% a 50%</option>
                        <option value="REMOTA">Remota: abaixo de 20%</option>
                    </select>
                </div><br>
                
                <div class="inputBox" class="container">
                    <label for="tipo_avaliacao" >Tipo de Avaliação: </label>
                    <select id="tipo_avaliacao" name="tipo_avaliacao">
                        <option value="INICIAL">Inicial</option>
                    </select>
                </div><br>

                <div class="inputBox" class="container">
                    <label for="ano_avaliacao">Ano da avaliação:</label>
                            <select name="ano_avaliacao" id="ano_avaliacao"  required>
                                <?php echo $ver_ano; ?>
                                
                            </select>
                </div><br>
                        
                <div class="inputBox" class="container">
                    <label for="mes_avaliacao" >Mês da Avaliação: </label>
                    <select id="mes_avaliacao" name="mes_avaliacao" >
                        <option value="Dezembro" <?php if($datam=="12") echo 'selected="selected"'; ?>>Dezembro</option>
                        <option value="Novembro" <?php if($datam=="11") echo 'selected="selected"'; ?>>Novembro</option>
                        <option value="Outubro" <?php if($datam=="10") echo 'selected="selected"'; ?>>Outubro</option>
                        <option value="Setembro" <?php if($datam=="09") echo 'selected="selected"'; ?>>Setembro</option>
                        <option value="Agosto" <?php if($datam=="08") echo 'selected="selected"'; ?>>Agosto</option>
                        <option value="Julho" <?php if($datam=="07") echo 'selected="selected"'; ?>>Julho</option>
                        <option value="Junho" <?php if($datam=="06") echo 'selected="selected"'; ?>>Junho</option>
                        <option value="Maio" <?php if($datam=="05") echo 'selected="selected"'; ?>>Maio</option>
                        <option value="Abril" <?php if($datam=="04") echo 'selected="selected"'; ?>>Abril</option>
                        <option value="Março" <?php if($datam=="03") echo 'selected="selected"'; ?>>Março</option>
                        <option value="Fevereiro" <?php if($datam=="02") echo 'selected="selected"'; ?>>Fevereiro</option>
                        <option value="Janeiro"<?php if($datam=="01") echo 'selected="selected"'; ?>>Janeiro</option>
                    </select>
                </div><br><br>

                <input type="hidden" name="id_pasta" id="id_pasta" value="<?php echo $id_pasta;?>">
                <input type="submit" name="submit" id="submit" value='Enviar'>
                <input type="hidden" name="logado" id="logado" value="<?php echo $logado;?>">
                <input type="hidden" name="horario" id="horario" value="<?php echo $horario;?>">
            </fieldset>
        </form>
    </div>
    
</body>
</html>