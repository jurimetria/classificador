<?php

# UTILIZADA PARA ATIVAR O LINK ENTRE A PASTA DESEJADA E OS DADOS DO DATALAKE

    session_start();
    include('config2.php');
    include('config.php');
    include('salvaDados.php');



    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
    
    if(!empty($id_pasta = $_GET['id_pasta']))
    {
        $pdo = conectar();

        $stmt = $pdo->prepare('SELECT * FROM view_11_folders WHERE pasta=\''.$id_pasta.'\'');
        $stmt->execute();
        $db_f = $stmt->fetch(PDO::FETCH_ASSOC);

    }




    include('script.js');
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
    <?php echo $navBarClean ?><br>

    <div class="row">
        <div class="column side2 alignLeft">
            <!-- BOTÃO VOLTAR -->
            <div class=' alignTop'>
                <button class='button2' onclick="goBack()">Voltar</button>
            </div>

            <!-- BOTÃO PROCURAR OUTRA PASTA -->
            <div class=' alignTop'>
                <?php
                        {echo "<a class='button2' href='index.php' title='Procurar Outra Pasta'> Procurar Outra Pasta</a>";
                        }
                ?>
            </div>



        <div class="column side2 alignCenter">
            <div class="box">
                <form action="" method="POST">
                    <fieldset>
                        <legend id='padding12'><a><b>Ativar Uma Nova Pasta </b></a></legend>
                        <br><br>
                        

                        <div class="inputBox" class="container">
                        <label for="binaria" >É Binária? </label>
                            <select id="binaria" name="binaria">
                            <option value="Não">Não</option>
                            <option value="Sim">Sim</option>
                            
                            </select>
                        </div>
                        <br><br>

                        <div class="inputBox">
                            <input type = "text" name="cargo" id="cargo" class="inputUser" >
                            <label for="cargo" class="labelInput">Cargo</label>
                        </div>
                        <br>

                        <div class="inputBox">
                            <input type = "text" name="periodo" id="periodo" class="inputUser"  >
                            <label for="periodo" class="labelInput">Período Discutido</label>
                        </div>
                        <br>

                        <div class="inputBox">
                            <input type = "text" name="comarca" id="comarca" class="inputUser" >
                            <label for="comarca" class="labelInput">Comarca</label>
                        </div>
                        <br>

                        <div class="inputBox">
                            <input type = "number" step="0.01" min="0"  name="salario" id="salario" class="inputUser"  >
                            <label for="salario" class="labelInput">Última Remuneração</label>
                        </div>
                        <br>

                        <div class="inputBox">
                        <label for="obs" class="label">Observações</label>
                            <textarea name="obs" id="obs" class="obsBox" rows="4" cols="50" placeholder="Observações..."></textarea>
                        </div>
                        <br>
                        
                        <input type="submit" name="submit" id="submit" value='Enviar'>
                        <input type="hidden" name="logado" id="logado" value="<?php echo $logado;?>">
                        <input type="hidden" name="horario" id="horario" value="<?php echo $horario;?>">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

</body>
</html>

<script>
    function goBack() {
    window.history.back();
    }
</script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>