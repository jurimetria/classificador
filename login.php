<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-image: white;
        }
        .tela-login{
            background-color: rgba(0, 0, 0, 0.8);
            position: absolute;
            top:50%;
            left:50%;
            transform: translate(-50%,-50%);
            padding: 80px;
            border-radius: 15px;
            color: white;
        }
        input{
            padding: 15px;
            border: none;
            outline: none;
            font-size: 15px;

        }
        .inputSubmit{
            background-color: dodgerblue;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 10px;
            color: white;
            font-size: 15px;

        }
        .inputSubmit:hover{
            background-color: rgba(30, 143, 255, 0.822);
        }
        img {
        display: block;

        margin-left: auto;
        margin-right: auto;
        }

    </style>
</head>
<body>
    <div class="tela-login">
        <div class='img'>
        <img src="https://lp-classificador.s3.amazonaws.com/img/LogoBranco+-+P1.png" alt="logo" width="46" height="46">
        <br>
        </div>
    

        <h1>Login</h1>
        <form action="testLogin.php" method="POST">
            <input type="text" name="email" placeholder="email">
            <br><br>
            <input type="password" name="senha" placeholder="senha">
            <br><br>
            <input class="inputSubmit" type="submit" name="submit" value="Enviar">
        </form>
    </div>
    
</body>
</html>