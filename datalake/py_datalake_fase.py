import pandas as pd
from datetime import date
import time
import numpy as np

# Comeca a rodar as 9:30 UTC

print("Carrega arquivo datalake-fase.csv do dia anterior")
# Lê os dados da ultima query
df_anterior = pd.read_csv("C:\\xampp\\htdocs\\dashboard\\datalake\\datalake-fase.csv", delimiter=",", encoding = "UTF-8", engine='python') 

time.sleep(1)
print("Elimina vazios do df_anterior")
# REPLACE NaTs e nan = Isso altera o type de algumas colunas
elimina_df_anterior = df_anterior.replace(np.nan, '', regex=True)
elimina_df_anterior_1 = elimina_df_anterior[elimina_df_anterior.n_processo != '']
df_anterior = elimina_df_anterior_1

time.sleep(1)
print("Escolhe as colunas")
# Escolhe as colunas e coloca na base
df_anterior = df_anterior.iloc[:,[0,1,4,5,6,8]]

time.sleep(1)
print("Renomeia a coluna fase para ontem") 
renamedf_anterior = df_anterior.rename(columns = {'pasta':'pasta', 'fase':'ontem'})

time.sleep(1)
print("Carrega arquivo datalake.csv de hoje")
df_atual = pd.read_csv("C:\\xampp\\htdocs\\dashboard\\datalake\\datalake.csv", delimiter=",", encoding = "UTF-8") 

time.sleep(1)
print("Cria o dataframe")
# Cria o dataframe
df_atual = pd.DataFrame(df_atual)

time.sleep(1)
print("Elimina vazios do df_atual")
# REPLACE NaTs e nan = Isso altera o type de algumas colunas
elimina_df_atual = df_atual.replace(np.nan, '', regex=True)
elimina_df_atual_1 = elimina_df_atual[elimina_df_atual.n_processo != '']
df_atual = elimina_df_atual_1


time.sleep(1)
print("Escolhe as colunas e coloca na base")
# Escolhe as colunas e coloca na base
base = df_atual.iloc[:,[0,1,4,5,6,8]]


time.sleep(1)
print("Renomeia a coluna fase com 'hoje'") 
rename = base.rename(columns = {'pasta':'pasta', 'fase':'hoje'})


time.sleep(1)
print("Junta a tabela de ontem e a de hoje para comparar")
merged = pd.merge(renamedf_anterior,rename,on=['n_processo','pasta','unidade','area','ramo'], how='inner')



time.sleep(1)
print("Compara as duas colunas")
diferencas = np.where(merged['ontem'] != merged['hoje'], True, False)

time.sleep(1)
print("Localiza as diferencas")
merged["diferente"] = diferencas


time.sleep(1)
print("Seleciona somente os que sofreram mudança de ontem para hoje") 
merged = merged[merged['diferente'] == True]

time.sleep(1)
print("Deleta as colunas 'diferente' e 'ontem'") 
# deleta a coluna 'diferente'
merged = merged.drop(columns=['diferente','ontem'])

time.sleep(1)
print("Renomeia a coluna hoje para novo_status_fase") 
merged = merged.rename(columns = {'pasta':'pasta', 'hoje':'novo_status_fase'})


time.sleep(1)
print("Cria o dia de hoje como string")
hoje = date.today()
#hoje = "2022-01-25"

time.sleep(1)
print("Coloca a data de hoje na coluna data")
merged['data'] = hoje

time.sleep(1)
print("Carrega o dl-fase de ontem")
dl_ontem = pd.read_csv("C:\\xampp\\htdocs\\dashboard\\datalake\\dl-fase.csv", delimiter=",", encoding = "UTF-8", engine='python') 


time.sleep(1)
print("Concatena o resultado de hoje com o dl-fase de ontem")
# Adiciona os ativos, pois estava dando erro antecipar essa etapa
final = pd.concat([dl_ontem,merged],ignore_index=True)

time.sleep(1)
print("Exporta e salva o arquivo CSV final")
final.to_csv('C:/xampp/htdocs/dashboard/datalake/dl-fase.csv', index=False, encoding = "UTF-8")

time.sleep(1)
print("Se tudo deu certo até aqui, exporta e salva o datalake-fase de hoje para se tornar o de ontem amanhã")
df_atual.to_csv('C:/xampp/htdocs/dashboard/datalake/datalake-fase.csv', index=False, encoding = "UTF-8")


time.sleep(1)
print("Tudo pronto!")




