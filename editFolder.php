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

    $emExclusao="";
    $emExclusao2="";
    $emExclusao3="";
    if($db_f['folderDel']==='SIM'){
        $emExclusao = "PASTA EM PROCESSO DE EXCLUSÃO";
        $emExclusao2 = "Todo o seu conteúdo e pedidos serão apagados";
        $emExclusao3 = "Para reverter este procedimento entre em contato com o Administrador";
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
                    {echo "<a class='button2' href='sistema.php?id_pasta=$id_pasta' title='Voltar'> Voltar</a>";
                    }
            ?>
        </div>

                <!-- PASTA EM EXCLUSÃO -->
                <?php
            echo "<h1 class='text-danger'>$emExclusao</h1>";
            echo "<h3 class='text-danger'>$emExclusao2</h3>";
            echo "<h3 class='text-danger'>$emExclusao3</h3>";
        ?>


    <div class="box">
        <form action="saveEditFolder.php" method="POST">
            <fieldset>
                <legend id='padding12'><a><b>Editar Pasta: <?php echo $id_pasta ?></b></a></legend>
                <br>

                <!-- DROPDOWN AVALIADOR -->
                <div class="inputBox" class="container">
                    <label for="avaliador" >Avaliador: </label>
                    <?php

                        $statement = $pdo->prepare('SELECT avaliador FROM tb_folder WHERE id_pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_avaliador = $statement->fetch(PDO::FETCH_ASSOC);

                        $statement = $pdo->prepare("SELECT avaliador FROM tb_campos WHERE avaliador IS NOT NULL ");
                        $statement->execute();
                        $options = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
                       
                        
                        echo "<select id='avaliador' name='avaliador'>";
                        foreach($options as $option){
                            if($selected_avaliador['avaliador'] == $option) {
                                echo "<option selected='selected' value='$option'>$option</option>";
                            }
                            else {
                                echo "<option value='$option'>$option</option>";
                            }
                        }
                        echo "</select>";
                    ?>
                </div><br>

                <!-- DROPDOWN AREA -->
                <div class="inputBox" class="container">
                    <label for="area" >Área: </label>
                    <?php

                        $statement = $pdo->prepare('SELECT area FROM tb_folder WHERE id_pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_area = $statement->fetch(PDO::FETCH_ASSOC);

                        $statement = $pdo->prepare("SELECT area FROM tb_campos WHERE area IS NOT NULL ORDER BY area DESC");
                        $statement->execute();
                        $options = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
                       
                        
                        echo "<select id='area' name='area'>";
                        foreach($options as $option){
                            if($selected_area['area'] == $option) {
                                echo "<option selected='selected' value='$option'>$option</option>";
                            }
                            else {
                                echo "<option value='$option'>$option</option>";
                            }
                        }
                        echo "</select>";
                    ?>
                </div><br>


                <!-- DROPDOWN UNIDADE -->
                <div class="inputBox" class="container">
                    <label for="unidade" >Unidade: </label>
                    <?php

                        $statement = $pdo->prepare('SELECT unidade FROM tb_folder WHERE id_pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_unidade = $statement->fetch(PDO::FETCH_ASSOC);

                        $statement = $pdo->prepare("SELECT unidade FROM tb_campos WHERE unidade IS NOT NULL ORDER BY unidade DESC");
                        $statement->execute();
                        $options = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
                       
                        
                        echo "<select id='unidade' name='unidade'>";
                        foreach($options as $option){
                            if($selected_unidade['unidade'] == $option) {
                                echo "<option selected='selected' value='$option'>$option</option>";
                            }
                            else {
                                echo "<option value='$option'>$option</option>";
                            }
                        }
                        echo "</select>";
                    ?>
                </div><br>

                <!-- DROPDOWN ANO AVALIAÇAO -->
                <div class="inputBox" class="container">
                    <label for="ano_aval" >Ano da Avaliação: </label>
                    <?php

                        $statement = $pdo->prepare('SELECT ano_aval FROM tb_folder WHERE id_pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_ano_aval = $statement->fetch(PDO::FETCH_ASSOC);

                        $statement = $pdo->prepare("SELECT ano FROM tb_campos WHERE ano <= $ano_atual ORDER BY ano DESC");
                        $statement->execute();
                        $options = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
                       
                        
                        echo "<select id='ano_aval' name='ano_aval'>";
                        foreach($options as $option){
                            if($selected_ano_aval['ano_aval'] == $option) {
                                echo "<option selected='selected' value='$option'>$option</option>";
                            }
                            else {
                                echo "<option value='$option'>$option</option>";
                            }
                        }
                        echo "</select>";
                    ?>
                </div><br>
                

                
                <div class="inputBox" class="container">
                <label for="mes_aval" >Mês da Avaliação: </label>
                    <select id="mes_aval" name="mes_aval" >
                        <option value="Dezembro" <?php if($db_f['mes_aval']=="Dezembro") echo 'selected="selected"'; ?>>Dezembro</option>
                        <option value="Novembro" <?php if($db_f['mes_aval']=="Novembro") echo 'selected="selected"'; ?>>Novembro</option>
                        <option value="Outubro" <?php if($db_f['mes_aval']=="Outubro") echo 'selected="selected"'; ?>>Outubro</option>
                        <option value="Setembro" <?php if($db_f['mes_aval']=="Setembro") echo 'selected="selected"'; ?>>Setembro</option>
                        <option value="Agosto" <?php if($db_f['mes_aval']=="Agosto") echo 'selected="selected"'; ?>>Agosto</option>
                        <option value="Julho" <?php if($db_f['mes_aval']=="Julho") echo 'selected="selected"'; ?>>Julho</option>
                        <option value="Junho" <?php if($db_f['mes_aval']=="Junho") echo 'selected="selected"'; ?>>Junho</option>
                        <option value="Maio" <?php if($db_f['mes_aval']=="Maio") echo 'selected="selected"'; ?>>Maio</option>
                        <option value="Abril" <?php if($db_f['mes_aval']=="Abril") echo 'selected="selected"'; ?>>Abril</option>
                        <option value="Março" <?php if($db_f['mes_aval']=="Março") echo 'selected="selected"'; ?>>Março</option>
                        <option value="Fevereiro" <?php if($db_f['mes_aval']=="Fevereiro") echo 'selected="selected"'; ?>>Fevereiro</option>
                        <option value="Janeiro"<?php if($db_f['mes_aval']=="Janeiro") echo 'selected="selected"'; ?>>Janeiro</option>
                    </select>
                </div>
                <br><br>


                <div class="inputBox">
                    <input type = "text" name="reclamante" id="reclamante" class="inputUser" value="<?php echo $db_f['reclamante']; ?>" required>
                    <label for="reclamante" class="labelInput">Reclamante</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="reclamada" id="reclamada" class="inputUser" value="<?php echo $db_f['reclamada'] ?>" >
                    <label for="reclamada" class="labelInput">Reclamada</label>
                </div>
                <br>

                <div class="inputBox" class="container">
                <label for="ramo" >Ramo: </label>
                    <select id="ramo" name="ramo">
                    <option value="Bancário" <?php if($db_f['ramo']=="Bancário") echo 'selected="selected"'; ?>>Bancário</option>
                    <option value="Não Bancário" <?php if($db_f['ramo']=="Não Bancário") echo 'selected="selected"'; ?>>Não Bancário</option>
                    </select>
                </div>

                <br>
                <div class="inputBox" class="container">
                <label for="binaria" >É Binária: </label>
                    <select id="binaria" name="binaria">
                    <option value="Sim" <?php if($db_f['binaria']=="Sim") echo 'selected="selected"'; ?>>Sim</option>
                    <option value="Não" <?php if($db_f['binaria']=="Não") echo 'selected="selected"'; ?>>Não</option>
                    </select>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="cargo" id="cargo" class="inputUser" value="<?php echo $db_f['cargo'] ?>" >
                    <label for="cargo" class="labelInput">Cargo</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="periodo" id="periodo" class="inputUser" value="<?php echo $db_f['periodo'] ?>" >
                    <label for="periodo" class="labelInput">Período Discutido</label>
                </div>
                <br>

                <div class="input-group" >
                    <label for="honorarios_perc" > Porcentagem Honorários &nbsp;&nbsp;  </label>
                    <input type="number" min="0" max="100" placeholder="100" name="honorarios_perc" id="honorarios_perc"  class="form-control " aria-label="" value="<?php echo $db_f['honorarios_perc'] ?>">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <br>

                <div class="inputBox">
                    <input type = "text" name="comarca" id="comarca" class="inputUser" value="<?php echo $db_f['comarca'] ?>" >
                    <label for="comarca" class="labelInput">Comarca</label>
                </div>
                <br>

                <div class="inputBox">
                    <input type = "number" step="0.01" min="0" name="salario" id="salario" class="inputUser" value="<?php echo $db_f['salario'] ?>" >
                    <label for="salario" class="labelInput">Última Remuneração</label>
                </div>
                <br>

                <!-- DROPDOWN TIPO AÇÃO -->
                <div class="inputBox" class="container">
                    <label for="tipo_acao" >Tipo de Ação: </label>
                    <?php

                        $statement = $pdo->prepare('SELECT tipo_acao FROM tb_folder WHERE id_pasta=\''.$id_pasta.'\'');
                        $statement->execute();
                        $selected_tipo_acao = $statement->fetch(PDO::FETCH_ASSOC);

                        $statement = $pdo->prepare("SELECT tipo_acao FROM tb_campos WHERE tipo_acao IS NOT NULL ");
                        $statement->execute();
                        $options = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
                       
                        
                        echo "<select id='tipo_acao' name='tipo_acao'>";
                        foreach($options as $option){
                            if($selected_tipo_acao['tipo_acao'] == $option) {
                                echo "<option selected='selected' value='$option'>$option</option>";
                            }
                            else {
                                echo "<option value='$option'>$option</option>";
                            }
                        }
                        echo "</select>";
                    ?>
                </div><br>


                <div class="inputBox">
                <label for="obs" class="label">Observações</label>
                    <textarea name="obs" id="obs" class="obsBox" rows="4" cols="50"><?php echo $db_f['obs'] ?></textarea>
                </div>
                <br>

                <input type="hidden" name="id_pasta" id="id_pasta" value="<?php echo $id_pasta;?>">
                <input type="hidden" name="logado" id="logado" value="<?php echo $logado;?>">
                <input type="hidden" name="horario" id="horario" value="<?php echo $horario;?>">
                <input type="submit" name="update" id="submit" value='Enviar'></input><br><br><br>

               
               
                <div class='alignCenter'  >
            <?php
                    {echo "<a id='submitRed' href='apagarPasta.php?id_pasta=$id_pasta' title='Apagar pasta'> Apagar esta pasta</a>";
                    }
            ?>
        </div>
            </fieldset>
        </form>
    </div>

</body>
</html>