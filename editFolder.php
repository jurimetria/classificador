<?php
    session_start();
    include('style.css');
    include('script.js');
    include('config2.php');

    $pdo = conectar();
        $id_pasta = $_GET['id_pasta'];

    if(!empty($_GET['id_pasta']))
    {

        $stmt = $pdo->prepare('SELECT * FROM tb_folder WHERE id_pasta=\''.$id_pasta.'\'');
        $stmt->execute();
        $db_f = $stmt->fetch(PDO::FETCH_ASSOC);

    }

// Salva dados da última alteração
    $logado = $_SESSION['email'];
    date_default_timezone_set('America/Sao_Paulo');
    $horario = date('m/d/Y h:i:s a', time());
 


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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="d-flex">
                <a href="login.php" class="btn btn-danger me-5">Sair</a>
            </div>
        </nav>
    </div>  

    <div>

    <div class='alingLeft alingTop'>
        <?php
                {echo "<a class='voltar' href='sistema.php?id_pasta=$id_pasta' title='Voltar'> Voltar</a>";
                }
        ?>
    </div>


    <div class="box">
        <form action="saveEditFolder.php" method="POST">
            <fieldset>
                <legend id='padding12'><a><b>Editar Pasta: <?php echo $id_pasta ?></b></a></legend>
                
                <div class="inputBox" class="container" >
                <label for="avaliador" >Avaliador: </label>
                    <select id="avaliador" name="avaliador" >
                    <option value="Meinel" <?php if($db_f['avaliador']=="Meinel") echo 'selected="selected"'; ?>>Meinel</option>
                    <option value="Juliane" <?php if($db_f['avaliador']=="Juliane") echo 'selected="selected"'; ?>>Juliane</option>
                    <option value="Carolina" <?php if($db_f['avaliador']=="Carolina") echo 'selected="selected"'; ?>>Carolina</option>
                    <option value="Filipe" <?php if($db_f['avaliador']=="Filipe") echo 'selected="selected"'; ?>>Filipe</option>
                    <option value="José" <?php if($db_f['avaliador']=="José") echo 'selected="selected"'; ?>>José</option>
                    </select>
                </div>
                <br>

                <div class="inputBox" class="container">
                <label for="area" >Área: </label>
                    <select id="area" name="area">
                    <option value="" >Escolha uma área</option>
                        <option value="Trabalhista" <?php if($db_f['area']=="Trabalhista") echo 'selected="selected"'; ?>>Trabalhista</option>
                        <option value="Previdenciário" <?php if($db_f['area']=="Previdenciário") echo 'selected="selected"'; ?>>Previdenciário</option>
                    </select>
                </div>
                <br>

                <div class="inputBox" class="container">
                <label for="ano_aval" >Ano da Avaliação: </label>
                    <select id="ano_aval" name="ano_aval">

                        <option value="2022" <?php if($db_f['ano_aval']=="2022") echo 'selected="selected"'; ?>>2022</option>
                        <option value="2021" <?php if($db_f['ano_aval']=="2021") echo 'selected="selected"'; ?>>2021</option>
                        <option value="2020" <?php if($db_f['ano_aval']=="2020") echo 'selected="selected"'; ?>>2020</option>
                    </select>
                </div>
                <br>

                
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
                    <input type = "text" name="reclamada" id="reclamada" class="inputUser" value="<?php echo $db_f['reclamada'] ?>" required>
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
                    <input type = "text" name="cargo" id="cargo" class="inputUser" value="<?php echo $db_f['cargo'] ?>" required>
                    <label for="cargo" class="labelInput">Cargo</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="periodo" id="periodo" class="inputUser" value="<?php echo $db_f['periodo'] ?>" >
                    <label for="periodo" class="labelInput">Período Discutido</label>
                </div>
                <br>

                <div class="inputBox">
                    <input type = "text" name="comarca" id="comarca" class="inputUser" value="<?php echo $db_f['comarca'] ?>" >
                    <label for="comarca" class="labelInput">Comarca</label>
                </div>
                <br>

                <div class="inputBox">
                    <input type = "text" name="salario" id="salario" class="inputUser" value="<?php echo $db_f['salario'] ?>" >
                    <label for="salario" class="labelInput">Última Remuneração</label>
                </div>
                <br>

                <div class="inputBox" class="container">
                <label for="tipo_acao" >Tipo de Ação </label>
                    <select id="tipo_acao" name="tipo_acao">
                    <option value="RT TÍPICA" <?php if($db_f['tipo_acao']=="RT TÍPICA") echo 'selected="selected"'; ?>>RT TÍPICA</option>
                    <option value="GRATIFICAÇÃO ESPECIAL" <?php if($db_f['tipo_acao']=="GRATIFICAÇÃO ESPECIAL") echo 'selected="selected"'; ?>>GRATIFICAÇÃO ESPECIAL</option>
                    <option value="GRADE" <?php if($db_f['tipo_acao']=="GRADE") echo 'selected="selected"'; ?>>GRADE</option>
                    <option value="PCS" <?php if($db_f['tipo_acao']=="PCS") echo 'selected="selected"'; ?>>PCS</option>
                    <option value="PLR" <?php if($db_f['tipo_acao']=="PLR") echo 'selected="selected"'; ?>>PLR</option>
                    <option value="VÍNCULO" <?php if($db_f['tipo_acao']=="VÍNCULO") echo 'selected="selected"'; ?>>VÍNCULO</option>
                    </select>
                </div>
                <br>


                <div class="inputBox">
                <label for="obs" class="label">Observações</label>
                    <textarea name="obs" id="obs" class="obsBox" rows="4" cols="50"><?php echo $db_f['obs'] ?></textarea>
                </div>
                <br>

                <input type="hidden" name="id_pasta" id="id_pasta" value="<?php echo $id_pasta;?>">
                <input type="hidden" name="logado" id="logado" value="<?php echo $logado;?>">
                <input type="hidden" name="horario" id="horario" value="<?php echo $horario;?>">
                <input type="submit" name="update" id="submit">
            </fieldset>
        </form>
    </div>

    


</body>
</html>