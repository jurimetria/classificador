<?php 

    include_once('config.php');

    if(isset($_POST['update']))
    {
        $n_registro = $_POST['n_registro'];
        $tipo_pedido = $_POST['tipo_pedido'];
        $valor_pedido = $_POST['valor_pedido'];
        $probabilidade = $_POST['probabilidade'];

        $sqlUpdate = "UPDATE tb_dados_valores SET tipo_pedido='$tipo_pedido', valor_pedido='$valor_pedido', probabilidade='$probabilidade'
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