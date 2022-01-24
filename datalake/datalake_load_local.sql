
SET SQL_SAFE_UPDATES = 0;
DELETE FROM tb_datalake;
LOAD DATA INFILE 'C:/xampp/htdocs/dashboard/datalake/datalake.csv' INTO TABLE tb_datalake FIELDS TERMINATED BY ','  IGNORE 1 LINES (n_processo, pasta);
