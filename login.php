
<?php

        include('style.css');
       ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='style.css' rel="stylesheet" type="text/css"/>
    
</head>
<body>
    <div class="tela-login">
        <div class='img'>
        <img src="https://lp-classificador.s3.amazonaws.com/img/LogoBranco+-+P1.png" alt="logo" width="70" height="70">
        <br>
        </div>
    

        <h1>Login</h1>
        <form action="testLogin.php" method="POST" class='inputBox'>
            <input class='inputUser' type="text" name="email" placeholder="email">
            
            <br><br>
            <input class='inputUser' type="password" name="senha" placeholder="senha">
            <br><br>
            <input class="inputSubmit" id="submit" type="submit" name="submit" value="Entrar">
        </form>
    </div>
    
</body>
</html>

