@echo off
@echo Executando...
@echo Exportando todos os dados que estão no lp_db
set hoje=%date:~10,4%%date:~4,2%%date:~7,2%


cd "C:\Program Files\MySQL\MySQL Server 8.0\bin\"

mysqldump --databases lp_db --column-statistics=0 -S localhost --user=root --password=Lp1406@  > C:\xampp\htdocs\dashboard\datalake\backup_lpdb\sql_backup_dump_lpdb-%hoje%.sql



@echo Pronto
timeout 10





