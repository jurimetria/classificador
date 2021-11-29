<?php
   

    session_start();
    // print_r($_REQUEST);
    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
        // Acessa
        include_once('config.php');
        $email = addslashes($_POST['email']);
        $senha = $_POST['senha'];
        
        $sql = "SELECT * FROM tb_usuarios WHERE email = '$email' and senha = '$senha'";

        $result = $conexao->query($sql);


        if(mysqli_num_rows($result) < 1)
        {
           echo '<div class="alert alert-error">Acesso negado</div>';
        }
        else
        {
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            header('Location: index.php');
        }
    }
    else
    {
        // Não acessa
        
        header('Location: login.php');
     
    }
?>