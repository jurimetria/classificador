

<?php
    session_start();
    if(!empty($_GET['n_registro']))
    {
        include('config2.php');
        $pdo = conectar();
        $n_registro = $_GET['n_registro'];

        $stmt = $pdo->prepare('SELECT * FROM tb_dados_valores WHERE n_registro=\''.$n_registro.'\'');
        $stmt->execute();
        $db_v = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_pasta = $db_v['id_pasta'];
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
            top: 50%;
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

    </style>
</head>
<body>
    
    
    <div>
    
        <button id="voltar">Voltar</button><br>
    </div>

    <div class="box">
        <form action="saveEditPedido.php" method="POST">
            <fieldset>
                <legend><b>Editar pedido # <a><?php echo $n_registro ?></a> - Pasta # <?php echo $id_pasta ?> </b></legend>
                <br><br>


                <div class="inputBox" class="container">
                <label for="tipo_pedido" >Pedido</label>
                    <select id="tipo_pedido" name="tipo_pedido">
                        <option value="7ª E 8ª HORAS" <?php if($db_v['tipo_pedido']=="7ª E 8ª HORAS") echo 'selected="selected"'; ?>>7ª E 8ª HORAS</option>
                        <option value="HORAS EXTRAS ALÉM DA 8ª" <?php if($db_v['tipo_pedido']=="HORAS EXTRAS ALÉM DA 8ª") echo 'selected="selected"'; ?>>HORAS EXTRAS ALÉM DA 8ª</option>
                        <option value="HORAS EXTRAS ALÉM DA 6ª" <?php if($db_v['tipo_pedido']=="HORAS EXTRAS ALÉM DA 6ª") echo 'selected="selected"'; ?>>HORAS EXTRAS ALÉM DA 6ª </option>
                        <option value="HORAS EXTRAS DE INTERVALO" <?php if($db_v['tipo_pedido']=="HORAS EXTRAS DE INTERVALO") echo 'selected="selected"'; ?>>HORAS EXTRAS DE INTERVALO</option>
                        <option value="EQUIPARAÇÃO SALARIAL" <?php if($db_v['tipo_pedido']=="EQUIPARAÇÃO SALARIAL") echo 'selected="selected"'; ?>>EQUIPARAÇÃO SALARIAL</option>
                        <option value="PERICULOSIDADE/INSALUBRIDADE" <?php if($db_v['tipo_pedido']=="PERICULOSIDADE/INSALUBRIDADE") echo 'selected="selected"'; ?>>PERICULOSIDADE/INSALUBRIDADE</option>
                        <option value="KM RODADO" <?php if($db_v['tipo_pedido']=="KM RODADO") echo 'selected="selected"'; ?>>KM RODADO</option>
                        <option value="GRATIFICAÇÃO ESPECIAL" <?php if($db_v['tipo_pedido']=="GRATIFICAÇÃO ESPECIAL") echo 'selected="selected"'; ?>>GRATIFICAÇÃO ESPECIAL</option>
                        <option value="GRADE ABN REAL" <?php if($db_v['tipo_pedido']=="GRADE ABN REAL") echo 'selected="selected"'; ?>>GRADE ABN REAL</option>
                        <option value="PCS" <?php if($db_v['tipo_pedido']=="PCS") echo 'selected="selected"'; ?>>PCS</option>
                        <option value="DANO MORAL" <?php if($db_v['tipo_pedido']=="DANO MORAL") echo 'selected="selected"'; ?>>DANO MORAL</option>
                        <option value="OUTROS" <?php if($db_v['tipo_pedido']=="OUTROS") echo 'selected="selected"'; ?>>OUTROS</option>
                    </select>
                </div>
                
                <br><br>
                <div class="inputBox">
                    <input type = "text" name="valor_pedido" id="valor_pedido" class="inputUser" value="<?php echo $db_v['valor_pedido'] ?>" required>
                    <label for="valor_pedido" class="labelInput">Valor pedido</label>
                </div>
                <br><br>



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
                <br><br>

                <input type="hidden" name="n_registro" id="n_registro" value="<?php echo $n_registro;?>">

               
                <input type="submit" name="update" id="update">
                
            </fieldset>
        </form>
    </div>
    <script type="text/javascript">
            document.getElementById("voltar").onclick = function () {
            window.location.href="sistema.php?id_pasta="+'<?php echo $db_v['id_pasta'];?>';}
    </script>
</body>
</html>