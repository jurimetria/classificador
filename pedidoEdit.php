

<?php
    session_start();
    include('config2.php');
    include('salvaDados.php');

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }

    $pdo = conectar();

    if(!empty($n_registro = $_GET['n_registro']))
    {

        $stmt = $pdo->prepare('SELECT * FROM tb_dados_valores WHERE n_registro=\''.$n_registro.'\'');
        $stmt->execute();
        $db_v = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_pasta = $db_v['id_pasta'];

        
    }
    else
    {
        header('Location: index.php');
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
<?php echo $navBarClean ?>
    
    <!-- BOTAO VOLTAR -->
    <div class='alignLeft alignTop'>
        <?php
                {echo "<a class='button2' href='sistema.php?id_pasta=$id_pasta' title='Voltar'> Voltar</a>";
                }
        ?>
    </div>

    <div class="box">
        <form action="pedidoSaveEdit.php" method="POST">
            <fieldset>
                <legend id='padding12'><a><b>Editar pedido # <?php echo $n_registro ?> - Pasta # <?php echo $id_pasta ?> </b></a></legend>
                <br><br>

                <!-- DROPDOWN TIPO PEDIDO -->
                <div class="inputBox" class="container">
                    <label for="tipo_pedido" >Pedido: </label>
                    <?php

                        $statement = $pdo->prepare('SELECT tipo_pedido FROM tb_dados_valores WHERE n_registro=\''.$n_registro.'\'');
                        $statement->execute();
                        $selected_tipo_pedido = $statement->fetch(PDO::FETCH_ASSOC);

                        $statement = $pdo->prepare("SELECT tipo_pedido FROM tb_campos WHERE tipo_pedido IS NOT NULL ");
                        $statement->execute();
                        $options = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
                       
                        
                        echo "<select id='tipo_pedido' name='tipo_pedido'>";
                        foreach($options as $option){
                            if($selected_tipo_pedido['tipo_pedido'] == $option) {
                                echo "<option selected='selected' value='$option'>$option</option>";
                            }
                            else {
                                echo "<option value='$option'>$option</option>";
                            }
                        }
                        echo "</select>";
                    ?>
                </div><br>


                <br>
                <div class="inputBox">
                    <input type = "number" step="0.01" min="0"  name="valor_pedido" id="valor_pedido" class="inputUser" value="<?php echo $db_v['valor_pedido'] ?>" required>
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

                <div class="inputBox" class="container">
                    <label for="tipo_avaliacao" >Tipo de Avaliação: </label>
                    <select id="tipo_avaliacao" name="tipo_avaliacao">
                     
                        <option value="INICIAL" <?php if($db_v['tipo_avaliacao']=="INICIAL") echo 'selected="selected"'; ?>>Inicial</option>
                        <option value="DECISAO PRIMEIRO GRAU" <?php if($db_v['tipo_avaliacao']=="DECISAO PRIMEIRO GRAU") echo 'selected="selected"'; ?>>Decisão de Primeiro Grau</option>
                        <option value="DECISAO SEGUNDO GRAU" <?php if($db_v['tipo_avaliacao']=="DECISAO SEGUNDO GRAU") echo 'selected="selected"'; ?>>Decisão de Segundo Grau</option>
                        <option value="LIQUIDACAO FINAL" <?php if($db_v['tipo_avaliacao']=="LIQUIDACAO FINAL") echo 'selected="selected"'; ?>>Liquidação final</option>
                        <option value="ACORDO" <?php if($db_v['tipo_avaliacao']=="ACORDO") echo 'selected="selected"'; ?>>Acordo</option>
 
                    </select>
                </div>
                <br>

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
                       
                        
                        echo "<select id='ano_avaliacao' name='ano_avaliacao'>";
                        foreach($options as $option){
                            if($selected_ano_aval['ano_avaliacao'] == $option) {
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
                <label for="mes_avaliacao" >Mês da Avaliação: </label>
                    <select id="mes_avaliacao" name="mes_avaliacao" >
                        <option value="Dezembro" <?php if($db_v['mes_avaliacao']=="Dezembro") echo 'selected="selected"'; ?>>Dezembro</option>
                        <option value="Novembro" <?php if($db_v['mes_avaliacao']=="Novembro") echo 'selected="selected"'; ?>>Novembro</option>
                        <option value="Outubro" <?php if($db_v['mes_avaliacao']=="Outubro") echo 'selected="selected"'; ?>>Outubro</option>
                        <option value="Setembro" <?php if($db_v['mes_avaliacao']=="Setembro") echo 'selected="selected"'; ?>>Setembro</option>
                        <option value="Agosto" <?php if($db_v['mes_avaliacao']=="Agosto") echo 'selected="selected"'; ?>>Agosto</option>
                        <option value="Julho" <?php if($db_v['mes_avaliacao']=="Julho") echo 'selected="selected"'; ?>>Julho</option>
                        <option value="Junho" <?php if($db_v['mes_avaliacao']=="Junho") echo 'selected="selected"'; ?>>Junho</option>
                        <option value="Maio" <?php if($db_v['mes_avaliacao']=="Maio") echo 'selected="selected"'; ?>>Maio</option>
                        <option value="Abril" <?php if($db_v['mes_avaliacao']=="Abril") echo 'selected="selected"'; ?>>Abril</option>
                        <option value="Março" <?php if($db_v['mes_avaliacao']=="Março") echo 'selected="selected"'; ?>>Março</option>
                        <option value="Fevereiro" <?php if($db_v['mes_avaliacao']=="Fevereiro") echo 'selected="selected"'; ?>>Fevereiro</option>
                        <option value="Janeiro"<?php if($db_v['mes_avaliacao']=="Janeiro") echo 'selected="selected"'; ?>>Janeiro</option>
                    </select>
                </div>
                <br><br>


                <input type="hidden" name="n_registro" id="n_registro" value="<?php echo $n_registro;?>">
                <input type="hidden" name="logado" id="logado" value="<?php echo $logado;?>">
                <input type="hidden" name="horario" id="horario" value="<?php echo $horario;?>">
                <input type="submit" name="update" id="submit" value='Enviar'>
            </fieldset>
        </form>
    </div>
    
</body>
</html>