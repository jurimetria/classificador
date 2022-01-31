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

        $stmt = $pdo->prepare('SELECT * FROM view_11_folders WHERE pasta=\''.$id_pasta.'\'');
        $stmt->execute();
        $db_f = $stmt->fetch(PDO::FETCH_ASSOC);

    }
    
    else
    {
        header('Location: pastaRegistro.php');
    }

    if(isset($_POST['submit']))
    {
        $logado = $_POST['logado'];
        $horario = $_POST['horario'];
        $id_pasta = $_POST['id_pasta'];
        $avaliador = $_POST['avaliador'];
        $mes_aval = $_POST['mes_aval'];
        $ano_aval = $_POST['ano_aval'];
        $binaria = $_POST['binaria'];
        $cargo = $_POST['cargo'];
        $periodo = $_POST['periodo'];
        $salario = $_POST['salario'];
        $obs = $_POST['obs'];

        $statement = $pdo->prepare("INSERT INTO tb_folder (logado,horario, id_pasta,avaliador,ano_aval,mes_aval,binaria,cargo,periodo,salario,obs)
        VALUES ('".$logado."','".$horario."','".$id_pasta."','".$avaliador."', '".$ano_aval."', '".$mes_aval."', '".$binaria."', '".$cargo."', '".$periodo."', '".$salario."', '".$obs."')");
        $statement->execute(array($logado, $horario, $id_pasta, $avaliador, $ano_aval, $mes_aval, $binaria, $cargo, $periodo, $salario,$obs));
    
        header('Location: sistema.php?id_pasta='.$id_pasta);}


    $dataExclusao= $db_f['horario'];
    $dataExclusao_ts= strtotime($dataExclusao. ' + 7 days');
    $dataExclusao_format = date('d/m/Y',$dataExclusao_ts);
    $emExclusao="";
    $emExclusao2="";
    $emExclusao3="";
    $emExclusao4="";



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
<?php echo $navBarClean ?>

    <div>
        <!-- BOTAO VOLTAR -->
        <div class='alignLeft alignTop'>
            <?php
                    {echo "<a class='button2' href='sistema.php?id_pasta=$id_pasta' title='Voltar'> Voltar</a>";
                    }
            ?>
        </div>



    <div class="box">
    <?php 
                    $stmtcn = $pdo->prepare('SELECT * FROM tb_folder WHERE id_pasta=\''.$id_pasta.'\'');
                    $stmtcn->execute();
                    $checknew = $stmtcn->fetch(PDO::FETCH_ASSOC);

                    if($checknew['binaria']!==null){
                        $novapasta="nao";}
                    else{ $novapasta="sim";}
                    
                    if($novapasta == "sim"){echo "<form action='' method='POST'>";}
                    if($novapasta == 'nao') {echo "<form action='pastaSaveEdit.php' method='POST'>";}
                ?>

    
            <fieldset>
                <legend id='padding12'><a><b>Editar Pasta: <?php echo $id_pasta ?></b></a></legend>
                <br><br>

                <!-- PARTE EXTRAIDA DO DATALAKE -->
                <p><b> Dados Extraídos do Datalake: </b></p>

                <!-- DO DATALAKE= AREA -->
                <div class="inputBox" class="container">
                    <label for="area" >Área: </label>
                    <?php
                        $statement = $pdo->prepare('SELECT * FROM tb_datalake WHERE pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected = $statement->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <input type = 'text' name='area' id='area' class='inputUser' value="<?php echo $selected['area'] ?>">
                </div><br>

                 <!-- DO DATALAKE= UNIDADE -->
                 <div class="inputBox" class="container">
                    <label for="area" >Unidade: </label>
                    <?php
                        $statement = $pdo->prepare('SELECT * FROM tb_datalake WHERE pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_area = $statement->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <input type = 'text' name='unidade' id='unidade' class='inputUser' value="<?php echo $selected['unidade'] ?>">
                </div><br>

                 <!-- DO DATALAKE= COMARCA -->
                 <div class="inputBox" class="container">
                    <label for="area" >Comarca: </label>
                    <?php
                        $statement = $pdo->prepare('SELECT * FROM tb_datalake WHERE pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_area = $statement->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <input type = 'text' name='comarca' id='comarca' class='inputUser' value="<?php echo $selected['comarca'] ?>">
                </div><br>

                <!-- DO DATALAKE= RECLAMANTE -->
                <div class="inputBox" class="container">
                    <label for="area" >Reclamante: </label>
                    <?php
                        $statement = $pdo->prepare('SELECT * FROM tb_datalake WHERE pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_area = $statement->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <input type = 'text' name='cliente' id='cliente' class='inputUser' value="<?php echo $selected['cliente'] ?>">
                </div><br>

                <!-- DO DATALAKE= PARTE RECLAMADA -->
                <div class="inputBox" class="container">
                    <label for="area" >Reclamada: </label>
                    <?php
                        $statement = $pdo->prepare('SELECT * FROM tb_datalake WHERE pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_area = $statement->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <input type = 'text' name='parte' id='parte' class='inputUser' value="<?php echo $selected['parte'] ?>">
                </div><br>

                <!-- DO DATALAKE= RAMO -->
                <div class="inputBox" class="container">
                    <label for="area" >Ramo: </label>
                    <?php
                        $statement = $pdo->prepare('SELECT * FROM tb_datalake WHERE pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_area = $statement->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <input type = 'text' name='ramo' id='ramo' class='inputUser' value="<?php echo $selected['ramo'] ?>">
                </div><br>

                <!-- DO DATALAKE= TIPO ACAO -->
                <div class="inputBox" class="container">
                    <label for="area" >Tipo de Ação: </label>
                    <?php
                        $statement = $pdo->prepare('SELECT * FROM tb_datalake WHERE pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_area = $statement->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <input type = 'text' name='tipo_de_acao' id='tipo_de_acao' class='inputUser' value="<?php echo $selected['tipo_de_acao'] ?>">
                </div><br>

                <!-- DO DATALAKE= FASE -->
                <div class="inputBox" class="container">
                    <label for="area" >Fase: </label>
                    <?php
                        $statement = $pdo->prepare('SELECT * FROM tb_datalake WHERE pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_area = $statement->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <input type = 'text' name='fase' id='fase' class='inputUser' value="<?php echo $selected['fase'] ?>">
                </div><br>

                <!-- DO DATALAKE= STATUS -->
                <div class="inputBox" class="container">
                    <label for="area" >Status: </label>
                    <?php
                        $statement = $pdo->prepare('SELECT * FROM tb_datalake WHERE pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_area = $statement->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <input type = 'text' name='status' id='status' class='inputUser' value="<?php echo $selected['status'] ?>">
                </div><br>

                <!-- DO DATALAKE= % HONORARIOS copiar linhas acima -->
                <div class="input-group" >
                    <label for="honorarios_perc" > Porcentagem Honorários &nbsp;&nbsp;  </label>
                    <input type="number" min="0" max="100" placeholder="100" name="honorarios_perc" id="honorarios_perc"  class="form-control " aria-label="" value="<?php echo $db_f['honorarios_perc'] ?>">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div><br><br>
                
                <!-- PARTE DISCRICIONÁRIA -->
                <p><b> Informações Complementares: </b></p>

                <div class="inputBox" class="container">
                <label for="binaria" >É Binária: </label>
                    <select id="binaria" name="binaria">
                    <option value="Sim" <?php if($db_f['binaria']=="Sim") echo 'selected="selected"'; ?>>Sim</option>
                    <option value="Não" <?php if($db_f['binaria']=="Não") echo 'selected="selected"'; ?>>Não</option>
                    </select>
                </div><br><br>
                
                <div class="inputBox">
                    <input type = "number" step="0.01" min="0" name="salario" id="salario" class="inputUser" value="<?php echo $db_f['salario'] ?>" >
                    <label for="salario" class="labelInput">Última Remuneração</label>
                </div><br>
                 
                <div class="inputBox">
                    <input type = "text" name="cargo" id="cargo" class="inputUser" value="<?php echo $db_f['cargo'] ?>" >
                    <label for="cargo" class="labelInput">Cargo</label>
                </div><br>
                
                <div class="inputBox">
                    <input type = "text" name="periodo" id="periodo" class="inputUser" value="<?php echo $db_f['periodo'] ?>" >
                    <label for="periodo" class="labelInput">Período Discutido</label>
                </div><br>
                
                <div class="inputBox">
                <label for="obs" class="label">Observações</label>
                    <textarea name="obs" id="obs" class="obsBox" rows="4" cols="50"><?php echo $db_f['obs'] ?></textarea>
                </div><br>
                
                <input type="hidden" name="novapasta" id="novapasta" value="<?php echo $novapasta;?>">
                <input type="hidden" name="id_pasta" id="id_pasta" value="<?php echo $id_pasta;?>">
                <input type="hidden" name="logado" id="logado" value="<?php echo $logado;?>">
                <input type="hidden" name="horario" id="horario" value="<?php echo $horario;?>">

                <?php 
                    $stmtcn = $pdo->prepare('SELECT * FROM tb_folder WHERE id_pasta=\''.$id_pasta.'\'');
                    $stmtcn->execute();
                    $checknew = $stmtcn->fetch(PDO::FETCH_ASSOC);

                    if($checknew['binaria']!==null){
                        $novapasta="nao";}
                    else{ $novapasta="sim";}
                    
                    if($novapasta == "sim"){echo "<input type='submit' name='submit' id='submit' value='Enviar'></input><br>";}
                    if($novapasta == 'nao') {echo "<input type='submit' name='update' id='submit' value='Enviar'></input><br>";}
                ?>

       
            </fieldset>
        </form>
    </div>

</body>
</html>
