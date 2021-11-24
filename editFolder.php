<?php
    session_start();
    
    if(!empty($_GET['id_pasta']))
    {
        include('config2.php');
        $pdo = conectar();
        $id_pasta = $_GET['id_pasta'];
       
        
        $stmt = $pdo->prepare('SELECT * FROM tb_folder WHERE id_pasta=\''.$id_pasta.'\'');
        $stmt->execute();
        $db_f = $stmt->fetch(PDO::FETCH_ASSOC);

    }

    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasta do Cliente</title>
    <style>
        body{font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, rgb(57, 126, 167), rgb(41, 51, 74));
        }
        .box{
            color: white;
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-color: rgba(0, 0, 0, 0.8);
            padding: 15px;
            border-radius: 15px;
            width: 20%;

        }
        fieldset{
            border: 3px solid dodgerblue;
        }
        legend{
            border: 1px solid dodgerblue;
            padding: 10px;
            text-align: left;
            background-color: dodgerblue;
            border-radius: 5px;

        }
        .inputBox{
            position: relative;
        }
        .inputUser{
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: white;
            font-size: 15px;
            width:100%;
            letter-spacing: 1px;

        }
        .labelInput{
            position: absolute;
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .5s;
        }
        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput{
            top: -20px;
            font-size: 12px;
            color: dodgerblue;
        }
        #update{
            background: dodgerblue;
            width: 100%;
            border: none;
            padding: 15px;
            color: white;
            font-size: 15px;
            cursor: pointer;
            border-radius: 10px;
        }
        #update:hover{
            background: rgba(30, 143, 255, 0.815);
        }
        .obsBox {
            background: none;
            border: none;
            border: 1px solid white;
            outline: none;
            color: white;
            font-size: 15px;
            width:100%;
            letter-spacing: 1px;
            width: 100%;
            height: 120px;
            border-radius: 4px;
            work-break: break-all;

        }

    </style>
</head>
<body>
    <div>

    <div>
    <button id="voltar">Voltar</button><br>
    </div>


    <div class="box">
        <form action="saveEditFolder.php" method="POST">
            <fieldset>
                <legend><b>Editar Pasta # <a><?php echo $id_pasta ?></a></b></legend>
                <br>
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
                <br><br>

                <div class="inputBox" class="container">
                <label for="area" >Área: </label>
                    <select id="area" name="area">
                    <option value="" >Escolha uma área</option>
                        <option value="Trabalhista" <?php if($db_f['area']=="Trabalhista") echo 'selected="selected"'; ?>>Trabalhista</option>
                        <option value="Previdenciário" <?php if($db_f['area']=="Previdenciário") echo 'selected="selected"'; ?>>Previdenciário</option>
                    </select>
                </div>
                <br><br>

                <div class="inputBox" class="container">
                <label for="ano_aval" >Ano da Avaliação: </label>
                    <select id="ano_aval" name="ano_aval">

                        <option value="2022" <?php if($db_f['ano_aval']=="2022") echo 'selected="selected"'; ?>>2022</option>
                        <option value="2021" <?php if($db_f['ano_aval']=="2021") echo 'selected="selected"'; ?>>2021</option>
                        <option value="2020" <?php if($db_f['ano_aval']=="2020") echo 'selected="selected"'; ?>>2020</option>
                    </select>
                </div>
                <br><br>

                
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
                <br><br>

                <div class="inputBox" class="container">
                <label for="ramo" >Ramo: </label>
                    <select id="ramo" name="ramo">
                    <option value="Bancário" <?php if($db_f['ramo']=="Bancário") echo 'selected="selected"'; ?>>Bancário</option>
                    <option value="Não Bancário" <?php if($db_f['ramo']=="Não Bancário") echo 'selected="selected"'; ?>>Não Bancário</option>
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
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="comarca" id="comarca" class="inputUser" value="<?php echo $db_f['comarca'] ?>" >
                    <label for="comarca" class="labelInput">Comarca</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="salario" id="salario" class="inputUser" value="<?php echo $db_f['salario'] ?>" >
                    <label for="salario" class="labelInput">Última Remuneração</label>
                </div>
                <br><br>

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
                <br><br>


                <div class="inputBox">
                <label for="obs" class="label">Observações</label>
                    <textarea name="obs" id="obs" class="obsBox" rows="4" cols="50"><?php echo $db_f['obs'] ?></textarea>
                    
                </div>
                <br><br>
                
                <br><br>
            
                <input type="hidden" name="id_pasta" id="id_pasta" value="<?php echo $id_pasta;?>">
                <input type="submit" name="update" id="update">
            </fieldset>
        </form>
    </div>

    <script type="text/javascript">
            document.getElementById("voltar").onclick = function () {
            window.location.href="sistema.php?id_pasta="+'<?php echo $db_f['id_pasta'];?>';}
    </script>


</body>
</html>