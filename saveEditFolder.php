<?php 
   
    include('config2.php');
    $pdo = conectar();

   

    if(isset($_POST['update']))
    {
        $id_pasta = $_POST['id_pasta'];
        $logado = $_POST['logado'];
        $horario = $_POST['horario'];
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
        $honorarios_perc = $_POST['honorarios_perc'];
        $comarca = $_POST['comarca'];
        $salario = $_POST['salario'];
        $tipo_acao = $_POST['tipo_acao'];
        $obs = $_POST['obs'];

        $sqlUpdate = "UPDATE tb_folder SET logado='$logado',horario='$horario', avaliador='$avaliador', area='$area', mes_aval='$mes_aval', ano_aval='$ano_aval', reclamante='$reclamante', reclamada='$reclamada', ramo='$ramo',binaria='$binaria', cargo='$cargo', periodo='$periodo', honorarios_perc='$honorarios_perc', comarca='$comarca', salario='$salario', tipo_acao='$tipo_acao', obs='$obs'
        WHERE id_pasta='$id_pasta'";

        $insert = $pdo->prepare($sqlUpdate);
        $result= $insert->execute(array($id_pasta,$logado,$horario, $avaliador,$area,$mes_aval,$ano_aval,$reclamante,$reclamada,$ramo,$binaria,$cargo,$periodo,$honorarios_perc, $comarca,$salario,$tipo_acao,$obs));

        
    }
    //print_r($result);
    header('Location: sistema.php?id_pasta='.$id_pasta);


?>