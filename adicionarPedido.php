<?php
    if(!empty($_GET['id_pasta']))
    {
        include_once('config.php');

        $id_pasta = $_GET['id_pasta'];
        $sqlSelect = "SELECT * FROM tb_dados_valores WHERE id_pasta=$id_pasta";


        $result = $conexao->query($sqlSelect);


        if(isset($_POST["submit"]))
        {

            
            $id_pasta = $_POST['id_pasta'];
            $tipo_pedido = $_POST['tipo_pedido'];
            $valor_pedido = $_POST['valor_pedido'];
            $probabilidade = $_POST['probabilidade'];

            $result = mysqli_query($conexao, "INSERT INTO tb_dados_valores (id_pasta,tipo_pedido,valor_pedido,probabilidade) 
            VALUES ('$id_pasta','$tipo_pedido','$valor_pedido','$probabilidade')");


            {
                header('Location: sistema.php?id_pasta='.$id_pasta);
            }
        }
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
        <?php
                {echo "<a class='btn btn-sm btn-primary' href='sistema.php?id_pasta=$id_pasta' title='Voltar'> Voltar</a>";
                }
        ?>
    </div>


    <div class="box">
        <form action="" method="POST">
            <fieldset>
                <legend><b>Novo pedido <a></a> - Pasta # <?php echo $id_pasta ?> </b></legend>
                <br><br>

                <div class="inputBox" class="container">
                <label for="tipo_pedido" >Pedido</label>
                    <select id="tipo_pedido" name="tipo_pedido">
                        <option value="">Escolha</option>
                        <option value="7ª E 8ª HORAS">7ª E 8ª HORAS</option>
                        <option value="HORAS EXTRAS ALÉM DA 8ª">HORAS EXTRAS ALÉM DA 8ª</option>
                        <option value="HORAS EXTRAS ALÉM DA 6ª ">HORAS EXTRAS ALÉM DA 6ª </option>
                        <option value="HORAS EXTRAS DE INTERVALO">HORAS EXTRAS DE INTERVALO</option>
                        <option value="EQUIPARAÇÃO SALARIAL">EQUIPARAÇÃO SALARIAL</option>
                        <option value="PERICULOSIDADE/INSALUBRIDADE">PERICULOSIDADE/INSALUBRIDADE</option>
                        <option value="KM RODADO">KM RODADO</option>
                        <option value="GRATIFICAÇÃO ESPECIAL">GRATIFICAÇÃO ESPECIAL</option>
                        <option value="GRADE ABN REAL">GRADE ABN REAL</option>
                        <option value="PCS">PCS</option>
                        <option value="DANO MORAL">DANO MORAL</option>
                        <option value="OUTROS">OUTROS</option>
                    </select>
                </div>
                
                <br><br>
                <div class="inputBox">
                    <input type = "text" name="valor_pedido" id="valor_pedido" class="inputUser"  required>
                    <label for="valor_pedido" class="labelInput">Valor pedido</label>
                </div>
                <br><br>

                <div class="inputBox" class="container">
                <label for="probabilidade" >Probabilidade de Êxito: </label>
                    <select id="probabilidade" name="probabilidade">
                        <option value="">Escolha</option>
                        <option value="Alta">Alta: 90% a 100%</option>
                        <option value="Provável">Provável: 70% a 90%</option>
                        <option value="Possível">Possível: 50% a 70%</option>
                        <option value="Baixa">Baixa: 20% a 50%</option>
                        <option value="Remota">Remota: abaixo de 20%</option>
                    </select>
                </div>
                <br><br>

                <input type="hidden" name="id_pasta" id="id_pasta" value="<?php echo $id_pasta;?>">
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </form>
    </div>
    
</body>
</html>