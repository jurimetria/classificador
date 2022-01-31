@echo off
@echo Executando...
@echo Exportando as pastas que estão no classificador

del C:\xampp\htdocs\dashboard\datalake\pastas_no_lpdb.csv /Q

cd "C:\Program Files\MySQL\MySQL Server 8.0\bin\"

mysql -S localhost --user=root --password=Lp1406@ --database="lp_db" < C:\xampp\htdocs\dashboard\datalake\sql_pastas_no_lpdb.sql



@echo Pronto
timeout 5




