

<?php
    session_start();
   
    include('script.js');
    if(!empty($_GET['n_registro']))
    {
        include('config2.php');
        $pdo = conectar();
        $n_registro = $_GET['n_registro'];



        if(!empty($_GET['id_pasta']))
        {
        $stmt = $pdo->prepare('SELECT * FROM tb_dados_valores WHERE n_registro=\''.$n_registro.'\'');
        $stmt->execute();
        $db_v = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_pasta = $db_v['id_pasta'];
    }

    // Salva dados da última alteração
    $logado = $_SESSION['email'];
    date_default_timezone_set('America/Sao_Paulo');
    $horario = date('m/d/Y h:i:s a', time());
      } else{

        header('Location: login.php');
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


    <!-- SAIR -->
    <div class="d-flex">
        <a href="login.php" class="btn btn-danger me-5">Sair</a>
    </div>
</nav>
</div>  
    
    <!-- VOLTAR -->
    <div class='alingLeft alingTop'>
        <?php
                {echo "<a class='voltar' href='sistema.php?id_pasta=$id_pasta' title='Voltar'> Voltar</a>";
                }
        ?>
    </div>

    <div class="box">
        <form action="saveEditPedido.php" method="POST">
            <fieldset>
                <legend id='padding12'><a><b>Editar pedido # <?php echo $n_registro ?> - Pasta # <?php echo $id_pasta ?> </b></a></legend>
                <br><br>


                <div class="inputBox" class="container">
                <label for="tipo_pedido" >Pedido</label>
                    <select id="tipo_pedido" name="tipo_pedido">
                        <option value="7ª E 8ª HORAS" <?php if($db_v['tipo_pedido']=="7ª E 8ª HORAS") echo 'selected="selected"'; ?>>7ª E 8ª HORAS</option>
                        <option value="HORAS EXTRAS ALÉM DA 8ª" <?php if($db_v['tipo_pedido']=="HORAS EXTRAS ALÉM DA 8ª") echo 'selected="selected"'; ?>>HORAS EXTRAS ALÉM DA 8ª</option>
                        <option value="HORAS EXTRAS ALÉM DA 6ª" <?php if($db_v['tipo_pedido']=="HORAS EXTRAS ALÉM DA 6ª") echo 'selected="selected"'; ?>>HORAS EXTRAS ALÉM DA 6ª </option>
                        <option value="HORAS EXTRAS DE INTERVALO" <?php if($db_v['tipo_pedido']=="HORAS EXTRAS DE INTERVALO") echo 'selected="selected"'; ?>>HORAS EXTRAS DE INTERVALO</option>
                        <option value="EQUIPARAÇÃO SALARIAL" <?php if($db_v['tipo_pedido']=="EQUIPARAÇÃO SALARIAL") echo 'selected="selected"'; ?>>EQUIPARAÇÃO SALARIAL</option>
                        <option value="PERICULOSIDADE/INSALUBRIDADE" <?php if($db_v['tipo_pedido']=="PERICULOSIDADE/INSALUBRIDADE") echo 'selected="selected"'; ?>>PERICULOSIDADE/INSALUBRIDADE</option>
                        <option value="KM RODADO" <?php if($db_v['tipo_pedido']=="KM RODADO") echo 'selected="selected"'; ?>>KM RODADO</option>
                        <option value="GRATIFICAÇÃO ESPECIAL" <?php if($db_v['tipo_pedido']=="GRATIFICAÇÃO ESPECIAL") echo 'selected="selected"'; ?>>GRATIFICAÇÃO ESPECIAL</option>
                        <option value="GRADE ABN REAL" <?php if($db_v['tipo_pedido']=="GRADE ABN REAL") echo 'selected="selected"'; ?>>GRADE ABN REAL</option>
                        <option value="PCS" <?php if($db_v['tipo_pedido']=="PCS") echo 'selected="selected"'; ?>>PCS</option>
                        <option value="DANO MORAL" <?php if($db_v['tipo_pedido']=="DANO MORAL") echo 'selected="selected"'; ?>>DANO MORAL</option>
                        <option value="OUTROS" <?php if($db_v['tipo_pedido']=="OUTROS") echo 'selected="selected"'; ?>>OUTROS</option>
                    </select>
                </div>
                
                <br>
                <div class="inputBox">
                    <input type = "text" name="valor_pedido" id="valor_pedido" class="inputUser" value="<?php echo $db_v['valor_pedido'] ?>" required>
                    <label for="valor_pedido" class="labelInput">Valor pedido</label>
                </div>
                
                <br>
                <div class="inputBox" class="container">
                <label for="probabilidade" >Probabilidade de Êxito</label>
                    <select id="probabilidade" name="probabilidade">
                        <option value="ALTA" <?php if($db_v['probabilidade']=="ALTA") echo 'selected="selected"'; ?>>Alta: 90% a 100%</option>
                        <option value="PROVÁVEL" <?php if($db_v['probabilidade']=="PROVÁVEL") echo 'selected="selected"'; ?>>Provável: 70% a 90%</option>
                        <option value="POSSÍVEL" <?php if($db_v['probabilidade']=="POSSÍVEL") echo 'selected="selected"'; ?>>Possível: 50% a 70%</option>
                        <option value="BAIXA" <?php if($db_v['probabilidade']=="BAIXA") echo 'selected="selected"'; ?>>Baixa: 20% a 50%</option>
                        <option value="REMOTA" <?php if($db_v['probabilidade']=="REMOTA") echo 'selected="selected"'; ?>>Remota: abaixo de 20%</option>
                    </select>
                </div>
                <br>
                <input type="hidden" name="n_registro" id="n_registro" value="<?php echo $n_registro;?>">
                <input type="hidden" name="logado" id="logado" value="<?php echo $logado;?>">
                <input type="hidden" name="horario" id="horario" value="<?php echo $horario;?>">
                <input type="submit" name="update" id="submit">
            </fieldset>
        </form>
    </div>
    
</body>
</html>