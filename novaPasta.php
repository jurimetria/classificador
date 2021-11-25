<?php
    session_start();
    

        include('config2.php');
        include('style.css');
        $pdo = conectar();
        
       
        
        $stmt = $pdo->prepare('SELECT * FROM tb_folder ');
        $stmt->execute();
        $db_f = $stmt->fetch(PDO::FETCH_ASSOC);

        if(isset($_POST['submit']))
        {
    
            $id_pasta = $_POST['id_pasta'];
            $avaliador = $_POST['avaliador'];
            $area = $_POST['area'];
            $mes_aval = $_POST['mes_aval'];
            $ano_aval = $_POST['ano_aval'];
            $reclamante = $_POST['reclamante'];
            $reclamada = $_POST['reclamada'];
            $ramo = $_POST['ramo'];
            $cargo = $_POST['cargo'];
            $periodo = $_POST['periodo'];
            $comarca = $_POST['comarca'];
            $salario = $_POST['salario'];
            $tipo_acao = $_POST['tipo_acao'];
            $obs = $_POST['obs'];
    
            $sqlInsert = "INSERT INTO tb_folder(id_pasta,avaliador,area,ano_aval,mes_aval,reclamante,reclamada,ramo,cargo,periodo,comarca,salario,tipo_acao,obs
            VALUES ('$id_pasta','$avaliador','$area','$ano_aval','$mes_aval','$reclamante','$reclamada','$ramo','$cargo','$periodo','$comarca','$salario','$tipo_acao','$obs')";

            $insert = $pdo->prepare($sqlInsert);
            $result= $insert->execute(array($id_pasta,$avaliador, $area,$mes_aval,$ano_aval,$reclamante,$reclamada,$ramo,$cargo,$periodo,$comarca,$salario,$tipo_acao,$obs));
            {
                header('Location: sistema.php?id_pasta='.$id_pasta);
            }
        }

    
        if( date('m') == 12){$data = "Dezembro";}
        if( date('m') == 11){$data = "Novembro";}
        if( date('m') == 10){$data = "Outubro";}
        if( date('m') == 9){$data = "Setembro";}
        if( date('m') == 8){$data = "Agosto";}
        if( date('m') == 7){$data = "Julho";}
        if( date('m') == 6){$data = "Junho";}
        if( date('m') == 5){$data = "Maio";}
        if( date('m') == 4){$data = "Abril";}
        if( date('m') == 3){$data = "Março";}
        if( date('m') == 2){$data = "Fevereiro";}
        if( date('m') == 1){$data = "Janeiro";}

?>
<!-- 


    

    -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasta do Cliente</title>
    
</head>
<body>
    <div>
    <button onclick="goBack()">Voltar</button><br>
    <button id="outraPasta">Procurar Outra Pasta</button><br>
    
    <div>

    </div>


    <div class="box">
        <form action="" method="POST">


            <fieldset>
                <legend><b>Cadastrar Nova Pasta </b></legend>
                <br>

                <div class="inputBox">
                    <input type = "text" name="id_pasta" id="id_pasta" class="inputUser" required>
                    <label for="id_pasta" class="labelInput">Número da Pasta</label>
                </div>
                <br><br>


                <div class="inputBox" class="container" >
                <label for="avaliador" >Avaliador: </label>
                    <select id="avaliador" name="avaliador" >
                    <option value="NÃO SELECIONADO">Escolha um avaliador</option>
                    <option value="Meinel">Meinel</option>
                    <option value="Juliane">Juliane</option>
                    <option value="Carolina" >Carolina</option>
                    <option value="Filipe">Filipe</option>
                    <option value="José">José</option>
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
                        <option value="2021" >2021</option>
                        
                    </select>
                </div>
                <br><br>

                
                <div class="inputBox" class="container">
                <label for="mes_aval" >Mês da Avaliação: </label>
                    <select id="mes_aval" name="mes_aval" >
                        <option value="Dezembro" <?php if($data=="Dezembro") echo 'selected="selected"'; ?>>Dezembro</option>
                        <option value="Novembro" <?php if($data=="Novembro") echo 'selected="selected"'; ?>>Novembro</option>
                        <option value="Outubro" <?php if($data=="Outubro") echo 'selected="selected"'; ?>>Outubro</option>
                        <option value="Setembro" <?php if($data=="Setembro") echo 'selected="selected"'; ?>>Setembro</option>
                        <option value="Agosto" <?php if($data=="Agosto") echo 'selected="selected"'; ?>>Agosto</option>
                        <option value="Julho" <?php if($data=="Julho") echo 'selected="selected"'; ?>>Julho</option>
                        <option value="Junho" <?php if($data=="Junho") echo 'selected="selected"'; ?>>Junho</option>
                        <option value="Maio" <?php if($data=="Maio") echo 'selected="selected"'; ?>>Maio</option>
                        <option value="Abril" <?php if($data=="Abril") echo 'selected="selected"'; ?>>Abril</option>
                        <option value="Março" <?php if($data=="Março") echo 'selected="selected"'; ?>>Março</option>
                        <option value="Fevereiro" <?php if($data=="Fevereiro") echo 'selected="selected"'; ?>>Fevereiro</option>
                        <option value="Janeiro"<?php if($data=="Janeiro") echo 'selected="selected"'; ?>>Janeiro</option>
                    </select>
                </div>
                <br><br>


                <div class="inputBox">
                    <input type = "text" name="reclamante" id="reclamante" class="inputUser"  required>
                    <label for="reclamante" class="labelInput">Reclamante</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="reclamada" id="reclamada" class="inputUser"  required>
                    <label for="reclamada" class="labelInput">Reclamada</label>
                </div>
                <br><br>

                <div class="inputBox" class="container">
                <label for="ramo" >Ramo: </label>
                    <select id="ramo" name="ramo">
                    <option value="" >Escolha um ramo</option>
                    <option value="Bancário">Bancário</option>
                    <option value="Não Bancário" >Não Bancário</option>
                    </select>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="cargo" id="cargo" class="inputUser" required>
                    <label for="cargo" class="labelInput">Cargo</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="periodo" id="periodo" class="inputUser" required >
                    <label for="periodo" class="labelInput">Período Discutido</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="comarca" id="comarca" class="inputUser" required>
                    <label for="comarca" class="labelInput">Comarca</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="salario" id="salario" class="inputUser" required >
                    <label for="salario" class="labelInput">Última Remuneração</label>
                </div>
                <br><br>

                <div class="inputBox" class="container">
                <label for="tipo_acao" >Tipo de Ação </label>
                    <select id="tipo_acao" name="tipo_acao">
                    <option value="" >Escolha um Tipo de Ação</option>
                    <option value="RT TÍPICA" >RT TÍPICA</option>
                    <option value="GRATIFICAÇÃO ESPECIAL" >GRATIFICAÇÃO ESPECIAL</option>
                    <option value="GRADE" >GRADE</option>
                    <option value="PCS" >PCS</option>
                    <option value="PLR" >PLR</option>
                    <option value="VÍNCULO" >VÍNCULO</option>
                    </select>
                </div>
                <br><br>

                <div class="inputBox">
                    <textarea name="obs" id="obs" class="obsBox" rows="4" cols="50" ></textarea>
                    <label for="obs" class="labelInput">Observações</label>
                </div>
                <br><br>
            
                
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </form>
    </div>
    <script type="text/javascript">
    document.getElementById("outraPasta").onclick = function () {
        location.href = "index.php";
    };
    </script>
</body>
</html>