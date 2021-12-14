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

    include('salvaDados.php');
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

            $result = mysqli_query($conexao, "INSERT INTO tb_dados_valores (logado, horario, id_pasta,tipo_pedido,valor_pedido,probabilidade,tipo_avaliacao) 
            VALUES ('$logado','$horario','$id_pasta','$tipo_pedido','$valor_pedido','$probabilidade','$tipo_avaliacao')");

            {
                header('Location: sistema.php?id_pasta='.$id_pasta);
            }
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


            <!-- SAIR -->
            <div class="d-flex">
                <a href="login.php" class="btn btn-danger me-5">Sair</a>
            </div>
        </nav>
    </div>  

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
                <legend id='padding12'><a><b>Novo pedido - Pasta: <?php echo $id_pasta ?> </b></a></legend>
                <br><br>

                <div class="inputBox" class="container">
                <label for="tipo_pedido">Pedido:</label>
                        <select name="tipo_pedido" id="tipo_pedido"  required>
                        <option value="" >Escolha...</option>
                            <?php echo $ver_tipo_pedido; ?>
                        </select>
                    </div>
                


                <br>
                <div class="inputBox">
                    <input type = "number" step="0.01" min="0" name="valor_pedido" id="valor_pedido" class="inputUser"  required>
                    <label for="valor_pedido" class="labelInput">Valor pedido</label>
                </div>
                <br>

                <div class="inputBox" class="container">
                    <label for="probabilidade" >Probabilidade de Êxito: </label>
                    <select id="probabilidade" name="probabilidade">
                    
                        <option value="ALTA">Alta: 90% a 100%</option>
                        <option value="PROVÁVEL">Provável: 70% a 90%</option>
                        <option value="POSSÍVEL">Possível: 50% a 70%</option>
                        <option value="BAIXA">Baixa: 20% a 50%</option>
                        <option value="REMOTA">Remota: abaixo de 20%</option>
                    </select>
                </div>
                <br>

                <div class="inputBox" class="container">
                    <label for="tipo_avaliacao" >Tipo de Avaliação: </label>
                    <select id="tipo_avaliacao" name="tipo_avaliacao">
                     
                        <option value="INICIAL">Inicial</option>
                        <option value="DECISAO PRIMEIRO GRAU">Decisão de Primeiro Grau</option>
                        <option value="DECISAO SEGUNDO GRAU">Decisão de Segundo Grau</option>
                        <option value="LIQUIDACAO FINAL">Liquidação final</option>
 
                    </select>
                </div>
                <br><br>

                <input type="hidden" name="id_pasta" id="id_pasta" value="<?php echo $id_pasta;?>">
                <input type="submit" name="submit" id="submit" value='Enviar'>
                <input type="hidden" name="logado" id="logado" value="<?php echo $logado;?>">
                <input type="hidden" name="horario" id="horario" value="<?php echo $horario;?>">
            </fieldset>
        </form>
    </div>
    
</body>
</html>