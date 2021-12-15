<?php
    
    if(!empty($_GET['n_registro']))
    {
        include_once('config.php');
        

        $n_registro = $_GET['n_registro'];

        $sqlSelect = "SELECT * FROM tb_dados_valores WHERE n_registro=$n_registro";
        // $sqlSelectFolder = "SELECT TOP 1* id_pasta FROM tb_dados_valores WHERE n_registro=$n_registro AS id_pasta";
        $sql_select_pasta = mysqli_query($conexao, "SELECT id_pasta AS meu_id FROM tb_dados_valores WHERE n_registro=$n_registro");

        $result_pasta = mysqli_fetch_assoc($sql_select_pasta);

        $pasta_id = $result_pasta['meu_id'];
        $result = $conexao->query($sqlSelect);

       
        if($result->num_rows > 0)
        {
            $sqlDelete = "DELETE FROM tb_dados_valores WHERE n_registro=$n_registro";
            $resultDelete = $conexao->query($sqlDelete);
        }
        header('Location: sistema.php?id_pasta='.$pasta_id); 
    }


?>

