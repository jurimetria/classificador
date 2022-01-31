@echo on

set hoje=%date:~10,4%%date:~4,2%%date:~7,2%

"C:\Program Files\7-Zip\7z.exe" a -tzip "C:\xampp\htdocs\dashboard\datalake\a.zip" "C:\xampp\htdocs\dashboard\datalake\backup_lpdb\*.*"
"C:\Program Files\7-Zip\7z.exe" a -tzip "C:\xampp\htdocs\dashboard\datalake\b.zip" "C:\xampp\htdocs\dashboard\datalake\backup_script_classificador\*.*"


"C:\Program Files\7-Zip\7z.exe" a -tzip "C:\xampp\htdocs\dashboard\datalake\backup_datalake_ec2\backup_datalake_ec2.zip" "C:\xampp\htdocs\dashboard\datalake\*.*"

del C:\xampp\htdocs\dashboard\datalake\a.zip /Q
del C:\xampp\htdocs\dashboard\datalake\b.zip /Q

@echo Pronto
timeout 5





