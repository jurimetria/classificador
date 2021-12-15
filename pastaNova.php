<?php 
    session_start();
    include('config2.php');
    include('salvaDados.php');
 

    
    $pdo = conectar();

        # VER OPÇÕES DE SELEÇÃO
        # VER AVALIADOR
        $ver_avaliador = '';
        $query = "SELECT DISTINCT avaliador FROM
            tb_campos WHERE avaliador IS NOT NULL ORDER BY avaliador ASC ";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach($result as $row)
        {
            $ver_avaliador .= '<option value="'.$row['avaliador'].'">'.$row['avaliador'].'</option>';
        }

        # VER AREA
        $ver_area = '';
        $query = "SELECT DISTINCT area FROM
            tb_campos WHERE area IS NOT NULL ORDER BY area DESC ";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach($result as $row)
        {
            $ver_area .= '<option value="'.$row['area'].'">'.$row['area'].'</option>';
        }

        # VER UNIDADE
        $ver_unidade = '';
        $query = "SELECT DISTINCT unidade FROM
            tb_campos WHERE unidade IS NOT NULL ORDER BY unidade ASC ";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach($result as $row)
        {
            $ver_unidade .= '<option value="'.$row['unidade'].'">'.$row['unidade'].'</option>';
        }




        # VER TIPO DE ACAO
        $ver_tipo_acao = '';
        $query = "SELECT DISTINCT tipo_acao FROM
            tb_campos WHERE tipo_acao IS NOT NULL ";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach($result as $row)
        {
            $ver_tipo_acao .= '<option value="'.$row['tipo_acao'].'">'.$row['tipo_acao'].'</option>';
        }




    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
        
    $stmt = $pdo->prepare('SELECT * FROM tb_folder ');
    $stmt->execute();
    $db_f = $stmt->fetch(PDO::FETCH_ASSOC);


 


    if(isset($_POST['submit']))
    {
        $logado = $_POST['logado'];
        $horario = $_POST['horario'];
        $id_pasta = $_POST['id_pasta'];
        $avaliador = $_POST['avaliador'];
        $area = $_POST['area'];
        $unidade = $_POST['unidade'];
        $mes_aval = $_POST['mes_aval'];
        $ano_aval = $_POST['ano_aval'];
        $reclamante = $_POST['reclamante'];
        $reclamada = $_POST['reclamada'];
        $ramo = $_POST['ramo'];
        $binaria = $_POST['binaria'];
        $cargo = $_POST['cargo'];
        $periodo = $_POST['periodo'];
        $honorarios_perc = $_POST['honorarios_perc'];
        $comarca = $_POST['comarca'];
        $salario = $_POST['salario'];
        $tipo_acao = $_POST['tipo_acao'];
        $obs = $_POST['obs'];

        $statement = $pdo->prepare("INSERT INTO tb_folder (logado,horario, id_pasta,avaliador,area,unidade,ano_aval,mes_aval,reclamante,reclamada,ramo,binaria,cargo,periodo,honorarios_perc,comarca,salario,tipo_acao,obs)
        VALUES ('".$logado."','".$horario."','".$id_pasta."','".$avaliador."', '".$area."', '".$unidade."', '".$ano_aval."', '".$mes_aval."', '".$reclamante."', '".$reclamada."', '".$ramo."', '".$binaria."', '".$cargo."', '".$periodo."','".$honorarios_perc."', '".$comarca."', '".$salario."', '".$tipo_acao."', '".$obs."')");
        $statement->execute(array($logado, $horario, $id_pasta, $avaliador, $area,$unidade, $ano_aval, $mes_aval, $reclamante, $reclamada, $ramo, $binaria, $cargo, $periodo, $honorarios_perc, $comarca, $salario, $tipo_acao, $obs));

        header('Location: sistema.php?id_pasta='.$id_pasta);
    }
    
    // Completa com o mês atual na caixa menu mês
    $datam = date('m');
    $dataa = date('Y');

    include('style.css');
    include('script.js');


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

            <div class=' alignTop text-warning'>
                <span ><b>Importante!</b></span><br><br>
                <span >No Número da Pasta copie e cole o número da Pasta </span><br>
                <span >como está no Judice</span><br>
                <span >É importante que sejam idênticos (e com underlines _ )</span><br><br>
                <span >Correto: POA_TRAB_11549</span><br>
                <span >Errado: TRAB 11549</span><br>

            </div><br>
        </div>

        <div class="column side2 alignCenter">
            <div class="box">
                <form action="" method="POST">
                    <fieldset>
                        <legend id='padding12'><a><b>Cadastrar Nova Pasta </b></a></legend>
                        <br><br>
                        

                        <div class="inputBox ">
                            <input type = "text" name="id_pasta" id="id_pasta" class="inputUser " required>
                        
                            <label for="id_pasta" class="labelInput">Número da Pasta</label>
                        </div>
                        <br>



                        <div class="inputBox" class="container">
                        <label for="avaliador">Avaliador:</label>
                                <select name="avaliador" id="avaliador"  required>
                                <option value="" >Escolha um avaliador</option>
                                    <?php echo $ver_avaliador; ?>
                                </select>
                            </div>
                        <br>


                        <div class="inputBox" class="container">
                        <label for="area">Área:</label>
                                <select name="area" id="area"  required>
                                    <?php echo $ver_area; ?>
                                </select>
                            </div>
                        <br>


                        <div class="inputBox" class="container">
                        <label for="unidade">Unidade:</label>
                                <select name="unidade" id="unidade"  required>
                                    <?php echo $ver_unidade; ?>
                                    
                                </select>
                            </div>
                        <br>




                        <div class="inputBox">
                            <input type = "text" name="reclamante" id="reclamante" class="inputUser"  required>
                            <label for="reclamante" class="labelInput">Reclamante</label>
                        </div>
                        <br>

                        <div class="inputBox">
                            <input type = "text" name="reclamada" id="reclamada" class="inputUser"  >
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


                        <div class="input-group" >
                            <label for="honorarios_perc" > Porcentagem Honorários &nbsp;&nbsp;  </label>
                            <input type="number" min="0" max="100" placeholder="100" name="honorarios_perc" id="honorarios_perc"  class="form-control " aria-label="" required>
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
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

                        <div class="inputBox" class="container">
                        <label for="tipo_acao">Tipo de Ação:</label>
                                <select name="tipo_acao" id="tipo_acao"  required>
                                    <option value="">Escolha um tipo de Ação</option>
                                    <?php echo $ver_tipo_acao; ?>
                                    
                                </select>
                            </div>
                        <br><br>


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