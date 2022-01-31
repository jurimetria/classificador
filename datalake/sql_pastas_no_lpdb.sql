SELECT id_pasta
FROM tb_folder
INTO OUTFILE 'C:/xampp/htdocs/dashboard/datalake/pastas_no_lpdb.csv'
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n';