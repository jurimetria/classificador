<?php 

    include_once('config.php');

    if(isset($_POST['update']))
    {
        $logado = $_POST['logado'];
        $horario = $_POST['horario'];
        $n_registro = $_POST['n_registro'];
        $tipo_pedido = $_POST['tipo_pedido'];
        $valor_pedido = $_POST['valor_pedido'];
        $probabilidade = $_POST['probabilidade'];
        $tipo_avaliacao = $_POST['tipo_avaliacao'];
        $ano_avaliacao = $_POST['ano_avaliacao'];
        $mes_avaliacao = $_POST['mes_avaliacao'];
        $avaliador = $_POST['avaliador'];
        $decisao = $_POST['decisao'];

        $sqlUpdate = "UPDATE tb_dados_valores SET logado='$logado',horario='$horario',tipo_pedido='$tipo_pedido', valor_pedido='$valor_pedido', probabilidade='$probabilidade', tipo_avaliacao='$tipo_avaliacao', ano_avaliacao='$ano_avaliacao', mes_avaliacao='$mes_avaliacao', avaliador='$avaliador', decisao='$decisao'
        WHERE n_registro='$n_registro'";

        $result = $conexao->query($sqlUpdate);
       // print_r($result);


    }

    $sql2 = "SELECT * FROM tb_dados_valores WHERE n_registro=$n_registro";
    $result2 = $conexao->query($sql2);

    while($user_data = mysqli_fetch_assoc($result2))
    {
    $id_pasta2 = $user_data['id_pasta'];}
    
    header('Location: sistema.php?id_pasta='.$id_pasta2); 
    

    

?>