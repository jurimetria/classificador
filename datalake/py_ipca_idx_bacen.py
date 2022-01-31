import pandas as pd

###############
# INDICE IPCA # >> BUSCA NA API DO BANCO CENTRAL
###############

print("Iniciando download via API do BACEN")
df = ""
df = pd.read_csv("http://api.bcb.gov.br/dados/serie/bcdata.sgs.433/dados?formato=csv", delimiter=";", encoding = "UTF-8") 
print("Download executado com sucesso")

print("Aplicando formatacao e criando tabela")
### Para realizar cálculos com a coluna valor, formatação a seguir
# Converter para float
df['valor'] = df['valor'].apply(lambda x: float(x.replace(".","").replace(",",".")))
df['valor'] = df['valor'].astype(float)
# converte a data para date
df['data'] = pd.to_datetime(df['data'], format='%d/%m/%Y').dt.date
# Converte a data para string
df['data'] = df['data'].astype(str)
# Filtra a data
df = df[df['data'] >= '1995-01-01']
# Cria um índice
df['ipca_idx'] = ((df.valor + 100) / 100.).cumprod()
xdata_out_ipca_idx = df
# Converte a data para date
xdata_out_ipca_idx['data'] = pd.to_datetime(xdata_out_ipca_idx['data'], format='%Y-%m-%d').dt.date

xdata_out_ipca_idx = xdata_out_ipca_idx.drop(columns=['valor'])

print("Tabela ipca_idx formatada e criada com sucesso")

print("Criando arquivo CSV")

xdata_out_ipca_idx.to_csv('C:/xampp/htdocs/dashboard/datalake/ipca_idx.csv', index=False)

print("Arquivo CSV ipca_idx criado com sucesso")