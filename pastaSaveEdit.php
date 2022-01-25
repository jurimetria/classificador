<?php 
   
    include('config2.php');
    $pdo = conectar();

   

    if(isset($_POST['update']))
    {
        $id_pasta = $_POST['id_pasta'];
        $logado = $_POST['logado'];
        $horario = $_POST['horario'];

 
        $mes_aval = $_POST['mes_aval'];
        $ano_aval = $_POST['ano_aval'];

        $binaria = $_POST['binaria'];
        $cargo = $_POST['cargo'];
        $periodo = $_POST['periodo'];
    
        $salario = $_POST['salario'];
       
        $obs = $_POST['obs'];

        $sqlUpdate = "UPDATE tb_folder SET logado='$logado',horario='$horario',   mes_aval='$mes_aval', ano_aval='$ano_aval', binaria='$binaria', cargo='$cargo', periodo='$periodo', salario='$salario',  obs='$obs'
        WHERE id_pasta='$id_pasta'";

        $insert = $pdo->prepare($sqlUpdate);
        $result= $insert->execute(array($id_pasta,$logado,$horario,$mes_aval,$ano_aval,$binaria,$cargo,$periodo,$salario,$obs));

        
    }
    //print_r($result);
    header('Location: sistema.php?id_pasta='.$id_pasta);


?>