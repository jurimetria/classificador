<?php
    session_start();
    include('config2.php');

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
    $id_pasta = $_GET['id_pasta'];
    if(!empty($_GET['id_pasta']))
    {
        include_once('config.php');
        $id_pasta = $_GET['id_pasta'];

        $sqlSelect = "SELECT * FROM tb_dados_valores WHERE id_pasta=$id_pasta";


        $result = $conexao->query($sqlSelect);


        if(isset($_POST["submit"]))
        {
            $id_pasta = $_POST['id_pasta'];
            $tipo_pedido = $_POST['tipo_pedido'];
            $valor_pedido = $_POST['valor_pedido'];
            $probabilidade = $_POST['probabilidade'];

            $result = mysqli_query($conexao, "INSERT INTO tb_dados_valores (id_pasta,tipo_pedido,valor_pedido,probabilidade) 
            VALUES ('$id_pasta','$tipo_pedido','$valor_pedido','$probabilidade')");

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
    <div class='alingLeft alingTop'>
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
                <br>

                <div class="inputBox">
                <label for="tipo_pedido" >Pedido</label>
                    <select id="tipo_pedido" name="tipo_pedido">
                        <option value="">Escolha</option>
                        <option value="7ª E 8ª HORAS">7ª E 8ª HORAS</option>
                        <option value="HORAS EXTRAS ALÉM DA 8ª">HORAS EXTRAS ALÉM DA 8ª</option>
                        <option value="HORAS EXTRAS ALÉM DA 6ª ">HORAS EXTRAS ALÉM DA 6ª </option>
                        <option value="HORAS EXTRAS DE INTERVALO">HORAS EXTRAS DE INTERVALO</option>
                        <option value="EQUIPARAÇÃO SALARIAL">EQUIPARAÇÃO SALARIAL</option>
                        <option value="PERICULOSIDADE/INSALUBRIDADE">PERICULOSIDADE/INSALUBRIDADE</option>
                        <option value="KM RODADO">KM RODADO</option>
                        <option value="GRATIFICAÇÃO ESPECIAL">GRATIFICAÇÃO ESPECIAL</option>
                        <option value="GRADE ABN REAL">GRADE ABN REAL</option>
                        <option value="PCS">PCS</option>
                        <option value="DANO MORAL">DANO MORAL</option>
                        <option value="ACÚMULO DE FUNÇÃO">ACÚMULO DE FUNÇÃO</option>
                        <option value="RESTABELECER GRAT. FUNÇÃO">RESTABELECER GRAT. FUNÇÃO</option>
                        <option value="OUTROS">OUTROS</option>
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
                        <option value="">Escolha</option>
                        <option value="Alta">Alta: 90% a 100%</option>
                        <option value="Provável">Provável: 70% a 90%</option>
                        <option value="Possível">Possível: 50% a 70%</option>
                        <option value="Baixa">Baixa: 20% a 50%</option>
                        <option value="Remota">Remota: abaixo de 20%</option>
                    </select>
                </div>
                <br><br>

                <input type="hidden" name="id_pasta" id="id_pasta" value="<?php echo $id_pasta;?>">
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </form>
    </div>
    
</body>
</html>