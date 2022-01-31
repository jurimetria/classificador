import pandas as pd
import time
import datetime
from datetime import date



print("Carrega arquivo dl-fase.csv onde estão todas as que sofreram alterações no último dia")
# Lê os dados da ultima query
df_dl_fase = pd.read_csv("C:\\xampp\\htdocs\\dashboard\\datalake\\dl-fase.csv", delimiter=",", encoding = "UTF-8", engine='python') 

time.sleep(1)
print("Seleciona somente as que sofreram alteração nos últimos 7 dias")
uma_semana = date.today()-datetime.timedelta(days=7)
# Converte de str para data
df_dl_fase['data'] = pd.to_datetime(df_dl_fase['data'], format='%Y-%m-%d').dt.date
df_dl_fase = df_dl_fase[df_dl_fase['data'] >= uma_semana]


time.sleep(1)
print("Escolhe as colunas e coloca na df_dl_fase")
# Escolhe as colunas e coloca na base
df_dl_fase = df_dl_fase.iloc[:,[1,2,3,4]]

print("Carrega arquivo pastas_no_lpdb.csv ")
# Lê os dados da ultima query
df_pastas_no_lpdb = pd.read_csv("C:\\xampp\\htdocs\\dashboard\\datalake\\pastas_no_lpdb.csv", delimiter=",", encoding = "UTF-8", engine='python') 

time.sleep(1)
print("Renomeia a coluna para pasta") 
df_pastas_no_lpdb = df_pastas_no_lpdb.rename(columns = {'@@':'pasta'})

time.sleep(1)
print("Junta a tabela das pastas que estão no class com as que sofreram alteracao, considerando 'pasta'")
merged = pd.merge(df_pastas_no_lpdb,df_dl_fase,on=['pasta'], how='inner')

time.sleep(1)
print("Exporta e salva o nome das pastas do classificador que sofreram alteração")
merged.to_csv('C:/xampp/htdocs/dashboard/datalake/alts_fase_class.csv', index=False, encoding = "UTF-8")

time.sleep(1)
print("Pronto")
time.sleep(3)
