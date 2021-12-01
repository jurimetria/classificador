<?php 
    session_start();
    include('config2.php');
    
    $pdo = conectar();

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
        
    $stmt = $pdo->prepare('SELECT * FROM tb_folder ');
    $stmt->execute();
    $db_f = $stmt->fetch(PDO::FETCH_ASSOC);



include('style.css');

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
        $binaria = $_POST['binaria'];
        $cargo = $_POST['cargo'];
        $periodo = $_POST['periodo'];
        $comarca = $_POST['comarca'];
        $salario = $_POST['salario'];
        $tipo_acao = $_POST['tipo_acao'];
        $obs = $_POST['obs'];

        $statement = $pdo->prepare("INSERT INTO tb_folder (id_pasta,avaliador,area,ano_aval,mes_aval,reclamante,reclamada,ramo,binaria,cargo,periodo,comarca,salario,tipo_acao,obs)
        VALUES ('".$id_pasta."','".$avaliador."', '".$area."', '".$ano_aval."', '".$mes_aval."', '".$reclamante."', '".$reclamada."', '".$ramo."', '".$binaria."', '".$cargo."', '".$periodo."', '".$comarca."', '".$salario."', '".$tipo_acao."', '".$obs."')");
        $statement->execute(array($id_pasta, $avaliador, $area, $ano_aval, $mes_aval, $reclamante, $reclamada, $ramo, $binaria, $cargo, $periodo, $comarca, $salario, $tipo_acao, $obs));

        header('Location: sistema.php?id_pasta='.$id_pasta);
    }
    
    // Completa com o mês atual na caixa menu mês

        $datam = date('m');
        $dataa = date('Y');
// print_r($dataa);

        include('style.css');
        include('script.js');


?>
<!-- 


    

    -->


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

<!-- BOTÃO VOLTAR -->
    <div class='alingLeft alingTop'>
        <button class='voltar' onclick="goBack()">Voltar</button>
    </div>

<!-- BOTÃO PROCURAR OUTRA PASTA -->
    <div class='alingLeft alingTop'>
        <?php
                {echo "<a class='voltar' href='index.php' title='Procurar Outra Pasta'> Procurar Outra Pasta</a>";
                }
        ?>
    </div>





    <div class="box">
        <form action="" method="POST">


            <fieldset>
                <legend id='padding12'><a><b>Cadastrar Nova Pasta </b></a></legend>
                <br><br>

                <div class="inputBox">
                    <input type = "text" name="id_pasta" id="id_pasta" class="inputUser" required>
                    <label for="id_pasta" class="labelInput">Número da Pasta</label>
                </div>
                <br>


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
                        <option value="2023" <?php if($dataa=="2023") echo 'selected="selected"'; ?>>2023</option>
                        <option value="2022" <?php if($dataa=="2022") echo 'selected="selected"'; ?>>2022</option>
                        <option value="2021" <?php if($dataa=="2021") echo 'selected="selected"'; ?>>2021</option>
                        <option value="2020" <?php if($dataa=="2020") echo 'selected="selected"'; ?>>2020</option>
                        <option value="2019" <?php if($dataa=="2019") echo 'selected="selected"'; ?>>2019</option>
                    </select>
                </div>
                <br>

                
                <div class="inputBox" class="container">
                <label for="mes_aval" >Mês da Avaliação: </label>
                    <select id="mes_aval" name="mes_aval" >
                        <option value="Dezembro" <?php if($datam=="12") echo 'selected="selected"'; ?>>Dezembro</option>
                        <option value="Novembro" <?php if($datam=="11") echo 'selected="selected"'; ?>>Novembro</option>
                        <option value="Outubro" <?php if($datam=="10") echo 'selected="selected"'; ?>>Outubro</option>
                        <option value="Setembro" <?php if($datam=="09") echo 'selected="selected"'; ?>>Setembro</option>
                        <option value="Agosto" <?php if($datam=="08") echo 'selected="selected"'; ?>>Agosto</option>
                        <option value="Julho" <?php if($datam=="07") echo 'selected="selected"'; ?>>Julho</option>
                        <option value="Junho" <?php if($datam=="06") echo 'selected="selected"'; ?>>Junho</option>
                        <option value="Maio" <?php if($datam=="05") echo 'selected="selected"'; ?>>Maio</option>
                        <option value="Abril" <?php if($datam=="04") echo 'selected="selected"'; ?>>Abril</option>
                        <option value="Março" <?php if($datam=="03") echo 'selected="selected"'; ?>>Março</option>
                        <option value="Fevereiro" <?php if($datam=="02") echo 'selected="selected"'; ?>>Fevereiro</option>
                        <option value="Janeiro"<?php if($datam=="01") echo 'selected="selected"'; ?>>Janeiro</option>
                    </select>
                </div>
                <br>


                <div class="inputBox">
                    <input type = "text" name="reclamante" id="reclamante" class="inputUser"  required>
                    <label for="reclamante" class="labelInput">Reclamante</label>
                </div>
                <br>

                <div class="inputBox">
                    <input type = "text" name="reclamada" id="reclamada" class="inputUser"  required>
                    <label for="reclamada" class="labelInput">Reclamada</label>
                </div>
                <br>

                <div class="inputBox" class="container">
                <label for="ramo" >Ramo: </label>
                    <select id="ramo" name="ramo">

                    <option value="Bancário">Bancário</option>
                    <option value="Não Bancário" >Não Bancário</option>
                    </select>
                </div>
                <br>

                <div class="inputBox" class="container">
                <label for="binaria" >É Binária? </label>
                    <select id="binaria" name="binaria">
                    <option value="Sim">Sim</option>
                    <option value="Não" >Não</option>
                    </select>
                </div>
                <br>

                <div class="inputBox">
                    <input type = "text" name="cargo" id="cargo" class="inputUser" required>
                    <label for="cargo" class="labelInput">Cargo</label>
                </div>
                <br>

                <div class="inputBox">
                    <input type = "text" name="periodo" id="periodo" class="inputUser" required >
                    <label for="periodo" class="labelInput">Período Discutido</label>
                </div>
                <br>

                <div class="inputBox">
                    <input type = "text" name="comarca" id="comarca" class="inputUser" required>
                    <label for="comarca" class="labelInput">Comarca</label>
                </div>
                <br>

                <div class="inputBox">
                    <input type = "number" step="0.01" min="0"  name="salario" id="salario" class="inputUser" required >
                    <label for="salario" class="labelInput">Última Remuneração</label>
                </div>
                <br>

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
                <label for="obs" class="label">Observações</label>
                    <textarea name="obs" id="obs" class="obsBox" rows="4" cols="50"></textarea>
                </div>
                <br>
                
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </form>
    </div>

</body>
</html>

<script>
function goBack() {
  window.history.back();
}
</script>