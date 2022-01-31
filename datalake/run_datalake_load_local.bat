@echo off
@echo Executando...
@echo Fazendo o upload do datalake em lp_db


cd "C:\Program Files\MySQL\MySQL Server 8.0\bin\"



mysql -S localhost --user=root --password=Lp1406@ --database="lp_db" < C:\xampp\htdocs\dashboard\datalake\sql_datalake_load_local.sql



