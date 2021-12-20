<?php

    
    

    // Salva dados da última alteração do usuário
    $logado = $_SESSION['email'];
    date_default_timezone_set('America/Sao_Paulo');
    $horario = date('m/d/Y h:i:s a', time());
    $ano_atual = date('Y');
    $hoje = date('d/m/Y');
    
    $pdo = conectar();
    $querylogadoAvaliador = $pdo->prepare('SELECT * FROM
    tb_usuarios  WHERE email=\''.$logado.'\' ');
    $querylogadoAvaliador->execute();
    $logadoResult = $querylogadoAvaliador->fetch(PDO::FETCH_ASSOC);
    $logadoAvaliador = $logadoResult['nome'];
    $logadoAvaliadorTipo = $logadoResult['secGroup'];
    $logadoAvaliadorArea = $logadoResult['area'];
    
    ?>