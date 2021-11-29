<?php

$state_prep = '
    SELECT *
    ,SUM(valor_pedido*prob_med) as cg_vm

    ,IF(f.binaria="Sim","F",
    IF(SUM(valor_pedido*prob_med)>=1000000, "AAA",
    IF((SUM(valor_pedido*prob_med)>=700000 AND SUM(valor_pedido*prob_med)<1000000), "AAB",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<700000), "ABB",
    IF((SUM(valor_pedido*prob_med)>=300000 AND SUM(valor_pedido*prob_med)<500000), "BBB",
    IF((SUM(valor_pedido*prob_med)>=200000 AND SUM(valor_pedido*prob_med)<300000), "BBC",
    IF((SUM(valor_pedido*prob_med)>=100000 AND SUM(valor_pedido*prob_med)<200000), "BCC",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<100000), "CCC",
    IF((SUM(valor_pedido*prob_med)<50000), "D",
    IF((SUM(valor_pedido*prob_med)=0), "E",
    ""
    )))))))))) as global_rating
    
    ,IF(f.binaria="Sim","R$ 300",
    IF(SUM(valor_pedido*prob_med)>=1000000, "R$ 1.000",
    IF((SUM(valor_pedido*prob_med)>=700000 AND SUM(valor_pedido*prob_med)<1000000), "R$ 850",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<700000), "R$ 700",
    IF((SUM(valor_pedido*prob_med)>=300000 AND SUM(valor_pedido*prob_med)<500000), "R$ 500",
    IF((SUM(valor_pedido*prob_med)>=200000 AND SUM(valor_pedido*prob_med)<300000), "R$ 400",
    IF((SUM(valor_pedido*prob_med)>=100000 AND SUM(valor_pedido*prob_med)<200000), "R$ 300",
    IF((SUM(valor_pedido*prob_med)>=500000 AND SUM(valor_pedido*prob_med)<100000), "R$ 250",
    IF((SUM(valor_pedido*prob_med)<50000), 0,
    IF((SUM(valor_pedido*prob_med)=0), "R$ 0",""
    )))))))))) as global_comissao
    
    ,IF(AVG(prob_med)>=0.9, "ALTA: 90%-100%",
    IF((AVG(prob_med)>=0.7 AND AVG(prob_med)<0.9), "PROVÁVEL: 70% a 90%",
    IF((AVG(prob_med)>=0.5 AND AVG(prob_med)<0.7),"POSSÍVEL: 50% a 70%",
    IF((AVG(prob_med)>=0.2 AND AVG(prob_med)<0.5), "BAIXA: 20% a 50%",
    IF((AVG(prob_med)<0.2), "REMOTA: abaixo de 20%",""

    ))))) as global_mde
    
    FROM tb_dados_valores v 
    INNER JOIN  tb_folder f ON v.id_pasta=f.id_pasta
    INNER JOIN tb_probabilidade p ON p.probabilidade=v.probabilidade

';
?>