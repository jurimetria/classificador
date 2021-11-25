
<?php 


    include('config2.php');
        $pdo = conectar();

        $query = "
    
        SELECT *
   ,SUM(valor_pedido*prob_med) as cg_vm
    ,IF(SUM(valor_pedido*prob_med)>=1000000, "AAA",
    IF((SUM(valor_pedido*prob_med)>=700000 AND SUM(valor_pedido*prob_med)<1000000), "AAB",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<700000), "ABB",
    IF((SUM(valor_pedido*prob_med)>=300000 AND SUM(valor_pedido*prob_med)<500000), "BBB",
    IF((SUM(valor_pedido*prob_med)>=200000 AND SUM(valor_pedido*prob_med)<300000), "BBC",
    IF((SUM(valor_pedido*prob_med)>=100000 AND SUM(valor_pedido*prob_med)<200000), "BCC",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<100000), "CCC",
    IF((SUM(valor_pedido*prob_med)<50000), "D",
    IF((SUM(valor_pedido*prob_med)=0), "E",
    "F"
    ))))))))) as global_rating
    
    ,IF(SUM(valor_pedido*prob_med)>=1000000, "R$ 1.000",
    IF((SUM(valor_pedido*prob_med)>=700000 AND SUM(valor_pedido*prob_med)<1000000), "R$ 850",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<700000), "R$ 700",
    IF((SUM(valor_pedido*prob_med)>=300000 AND SUM(valor_pedido*prob_med)<500000), "R$ 500",
    IF((SUM(valor_pedido*prob_med)>=200000 AND SUM(valor_pedido*prob_med)<300000), "R$ 400",
    IF((SUM(valor_pedido*prob_med)>=100000 AND SUM(valor_pedido*prob_med)<200000), "R$ 300",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<100000), "R$ 250",
    IF((SUM(valor_pedido*prob_med)<50000), 0,
    IF((SUM(valor_pedido*prob_med)=0), "R$ 0","R$ 300"
    ))))))))) as global_comissao
    
    ,IF(AVG(prob_med)>=0.9, "ALTA: 90%-100%",
    IF((AVG(prob_med)>=0.7 AND AVG(prob_med)<0.9), "PROVÁVEL: 70% a 90%",
    IF((AVG(prob_med)>=0.5 AND AVG(prob_med)<0.7),"POSSÍVEL: 50% a 70%",
    IF((AVG(prob_med)>=0.2 AND AVG(prob_med)<0.5), "BAIXA: 20% a 50%",
    IF((AVG(prob_med)<0.2), "REMOTA: abaixo de 20%",""
    ))))) as global_mde
    
    FROM tb_dados_valores v 
    INNER JOIN  tb_folder f ON v.id_pasta=f.id_pasta
    INNER JOIN tb_probabilidade p ON p.probabilidade=v.probabilidade
    
    GROUP BY f.id_pasta
        
    ";

    $column = array('id_pasta', 'tipo_acao','ramo', 'global_rating', 'global_comissao', 'cg_vm', 'global_mde');
    
    if(isset($_POST['filter_mes_aval'], $_POST['filter_ano_aval']) && $_POST['filter_mes_aval'] != '' && $_POST['filter_ano_aval'] != '')
    {
    $query .= 'WHERE mes_aval = "'.$_POST['filter_mes_aval'].'" AND ano_aval = "'.$_POST['filter_ano_aval'].'"';
    }

    if(isset($_POST['order']))
    {
        $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY f.id_pasta ASC';
    ==}///

    $query1 = '';

    if($_POST["length"] != -1)
    {
        $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

        $statement = $pdo->prepare($query);
        $statement->execute();
        $number_filter_row = $statement->rowCount();

        $statement = $pdo->prepare($query . $query1);
        $statement->execute();
        $result = $statement->fetchAll();



    $data = array();

    foreach($result as $row)
    {
        $sub_array = array();
        $sub_array[] = $row['id_pasta'];
        $sub_array[] = $row['tipo_acao'];
        $sub_array[] = $row['ramo'];
        $sub_array[] = $row['global_rating'];
        $sub_array[] = $row['global_comissao'];
        $sub_array[] = $row['cg_vm'];
        $sub_array[] = $row['global_mde'];
        $data[] = $sub_array;
    }
 
    function count_all_data($pdo)
    {
        $query = "
        SELECT *
        FROM tb_dados_valores v 
        INNER JOIN  tb_folder f ON v.id_pasta=f.id_pasta
        INNER JOIN tb_probabilidade p ON p.probabilidade=v.probabilidade
        ";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->rowCount();
       }

        $output = array(
        "draw"       =>  intval($_POST["draw"]),
        "recordsTotal"   =>  count_all_data($pdo),
        "recordsFiltered"  =>  $number_filter_row,
        "data"       =>  $data
    );

    echo json_encode($output);

?>