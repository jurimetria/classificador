<?php
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

        $stmt = $pdo->prepare('SELECT * FROM tb_folder WHERE id_pasta=\''.$id_pasta.'\'');
        $stmt->execute();
        $db_f = $stmt->fetch(PDO::FETCH_ASSOC);
        $db_f_aval = $db_f['avaliador'];
        
       



        

    }
    else
    {
        header('Location: index.php');
    }
   

    if(isset($_POST['update']))
    {
        $id_pasta = $_POST['id_pasta'];
        $logado = $_POST['logado'];
        $horario = $_POST['horario'];
        $folderDel = $_POST['folderDel'];
        $folderDelObs = $_POST['folderDelObs'];


        $sqlUpdate = "UPDATE tb_folder SET logado='$logado',horario='$horario', folderDel='$folderDel', folderDelObs='$folderDelObs'
        WHERE id_pasta='$id_pasta'";

        $insert = $pdo->prepare($sqlUpdate);
        $result= $insert->execute(array($id_pasta,$logado,$horario, $folderDelObs));

            //print_r($result);
    header('Location: index.php');
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

    <div>
        <!-- BOTAO VOLTAR -->
        <div class='alignLeft alignTop'>
            <?php
                    {echo "<a class='button2' href='sistema.php?id_pasta=$id_pasta' title='Voltar'> Cancelar e voltar</a>";
                    }
            ?>
        </div>

    <div class="box">
        <form action="" method="POST">
            <fieldset>
                <legend class='text-danger ' id='padding12'><a><b>Apagar Pasta: <?php echo $id_pasta ?></b></a></legend>
                <br>



                <div class="inputBox">
                <label for="folderDelObs" class="label">Descreva o motivo</label>
                    <textarea name="folderDelObs" id="folderDelObs" class="obsBox" rows="4" cols="50"></textarea>
                </div>
                <br>

                <input type="hidden" name="id_pasta" id="id_pasta" value="<?php echo $id_pasta;?>">
                <input type="hidden" name="logado" id="logado" value="<?php echo $logado;?>">
                <input type="hidden" name="horario" id="horario" value="<?php echo $horario;?>">
                <input type="hidden" name="folderDel" id="folderDel" value="SIM">
                <input type="submit" name="update" id="submitRed" value='Clique para apagar'>
               
            </fieldset>
        </form>
    </div>

</body>
</html>