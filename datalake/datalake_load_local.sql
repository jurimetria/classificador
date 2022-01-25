
SET SQL_SAFE_UPDATES = 0;
DELETE FROM tb_datalake;
LOAD DATA INFILE 'C:/xampp/htdocs/dashboard/datalake/datalake.csv' INTO TABLE tb_datalake FIELDS TERMINATED BY ','  IGNORE 1 LINES (n_processo, pasta, cliente, email,unidade, area, ramo, tipo_de_acao, fase, parte, comarca,motivo_encerramento, data_abertura, data_encerramento_processo, data_encerramento_pasta, data_reativacao, data_requerimento, data_ajuizamento, status, demora_aj_meses, demora_req_meses, decorrido_meses);
