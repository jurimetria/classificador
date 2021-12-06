import boto3 as aws
import pandas as pd
import warnings
import numpy as np
warnings.filterwarnings("ignore")



s3_resource = aws.client("s3")

ultimo_csv = "query_aws.2021-12-02-20.30.csv.gz"

s3_resource.download_file(Bucket="lp-judice-csv",Key=ultimo_csv,Filename="ultima_query.gz")







# df = pd.read_csv("C:\\Users\\mel85\\iCloudDrive\\01.L&P\\Dhuio\\2021julho.csv", delimiter=",", encoding = "ISO-8859-1") 
df = pd.read_csv("C:\\Users\\Administrator\\.spyder-py3\\ultima_query.gz", delimiter=",", encoding = "ISO-8859-1") 


# Cria o dataframe
df = pd.DataFrame(df)

# Escolhe as colunas e coloca na base
base = df.iloc[:,[1,2,3,4,5,6,8,9,10,11,12,13,14,15,16,23,24,45]]


######################
# FORMATAÇÃO INICIAL #
######################

format_f0 = base

# Elimina as linhas com namefolder vazio
format_f1 = format_f0[format_f0['namefolder']!='']

# Extrai somente a parte da data das seguintes colunas (hhmmss estava dando erro)
format_f1['createdate'] = format_f1.createdate.str.split(" ", expand=True)[0]
format_f1['distributiondate'] = format_f1.distributiondate.str.split(" ", expand=True, n=0)
format_f1['date_requerimento'] = format_f1.date_requerimento.str.split(" ", expand=True, n=0)
format_f1['closedate'] = format_f1.closedate.str.split(" ", expand=True)[0]
format_f1['closedatefolder'] = format_f1.closedatefolder.str.split(" ", expand=True, n=0)
format_f1['reativacao_date'] = format_f1.reativacao_date.str.split(" ", expand=True)[0]

# Converte as com data 5000 para null
format_f1 = format_f1.replace('5000-01-01', '', regex=True)
format_f1 = format_f1.replace('01/01/5000', '01/01/1991', regex=True)
format_f1 = format_f1.replace('5000-02-14', '', regex=True)
format_f1 = format_f1.replace('14/02/5000', '01/01/1991', regex=True)

# Converte de str para data
format_f1['createdate'] = pd.to_datetime(format_f1['createdate'], format='%Y-%m-%d').dt.date
format_f1['closedate'] = pd.to_datetime(format_f1['closedate'], format='%Y-%m-%d').dt.date
format_f1['closedatefolder'] = pd.to_datetime(format_f1['closedatefolder'], format='%Y-%m-%d').dt.date
format_f1['reativacao_date'] = pd.to_datetime(format_f1['reativacao_date'], format='%Y-%m-%d').dt.date
format_f1['distributiondate'] = pd.to_datetime(format_f1['distributiondate'], format='%Y-%m-%d').dt.date
format_f1['date_requerimento'] = pd.to_datetime(format_f1['date_requerimento'], format='%Y-%m-%d').dt.date
format_f1['dataabertura'] = pd.to_datetime(format_f1['dataabertura'], format='%Y-%m-%d').dt.date

# Formata outras colunas
format_f1['namefolder'] = format_f1['namefolder'].astype(str)
format_f1['nameparticipant'] = format_f1['nameparticipant'].str.upper()
format_f1['nameclient'] = format_f1['nameclient'].str.title()

base = format_f1


##############
# N_PROCESSO #
##############

nproc = base
# cria a coluna n_processo, colocando os dados da number
nproc['n_processo'] = nproc['number']

# se ficou vazia, usa o valor da cnjnumber
nproc[nproc.number=='']['n_processo'] = nproc['cnjnumber']

# Formata para str
nproc['n_processo'] = nproc['n_processo'].astype(str)

base = nproc


#####################
# DATA_ENCERRAMENTO #
#####################
 
dt_enc = base

# Serve só para encontrar os ativos
# Cria a coluna data_encerramento e coloca os dados que existirem da closedate nela
dt_enc['data_encerramento'] = dt_enc['closedate']

# dentro da data_encerramento, naquelas linhas da closedate que estavam vazias, colocar o valor da closedatefolder
dt_enc['data_encerramento'][dt_enc['closedate'].isna()] = dt_enc['closedatefolder']

dt_enc['data_encerramento'] = pd.to_datetime(dt_enc['data_encerramento'], format='%Y-%m-%d').dt.date

base = dt_enc


#################
# DATA_ABERTURA #
#################

dt_abert = base


# Cria a coluna data_abertura e coloca os dados que existirem da dataabertura nela
dt_abert['data_abertura'] = dt_abert['dataabertura']

# dentro da data_abertura, naquelas linhas  que estavam vazias, colocar o valor da data de ajuizamento distributiondate
dt_abert['data_abertura'][dt_abert['dataabertura'].isna()] = dt_abert['distributiondate']

# FORMATAR PARA DATE
dt_abert['data_abertura'] = pd.to_datetime(dt_abert['data_abertura'], format='%Y-%m-%d').dt.date

base = dt_abert


########################
# INICIA COLUNA STATUS #
########################

##############
# REATIVADOS # 
##############

reativados = base

# Se a data de reativação for maior que closedate ou closedatefolder
reativados = reativados[(reativados['reativacao_date'] >= reativados['closedate']) | (reativados['reativacao_date'] >= reativados['closedatefolder'])]

# Elimina pastas duplicadas, mantendo a última
reativados = reativados.drop_duplicates(subset=["namefolder"], keep="last")

# Aplica o selo status = Reativado
reativados['status'] = "Reativado"




##########
# ATIVOS #
##########

# Seleciona as linhas que têm data_encerramento vazio
ativos_f1 = base[base['data_encerramento'].isnull()]

# Exclui os seguintes termos da coluna namephase
ativos_f2a = ativos_f1[ativos_f1.namephase != 'BAIXADO']
ativos_f2d = ativos_f2a[ativos_f2a.namephase != 'DECLINADA A COMPETÊNCIA']
ativos_f2e = ativos_f2d[ativos_f2d.namephase != 'EXECUÇÃO PROVISÓRIA']
ativos_f2f = ativos_f2e[ativos_f2e.namephase != 'EXTINÇÃO']
ativos_f2g = ativos_f2f[ativos_f2f.namephase != 'IMPROCEDÊNCIA']
ativos_f2h = ativos_f2g[ativos_f2g.namephase != 'INCINERADO']
ativos_f2i = ativos_f2h[ativos_f2h.namephase != 'NÃO PERFIL - TRABALHISTA']
ativos_f2j = ativos_f2i[ativos_f2i.namephase != 'PROSPECT']

# Exclui se contiver a palavra encerrado em namephase
ativos_f3 = ativos_f2j[~ativos_f2j.namephase.str.match(r'\.encerrado\.', case=True)]

# Exclui os seguintes termos da coluna nameactiontype
ativos_f5b = ativos_f3[ativos_f3.nameactiontype != 'AGRAVO DE INSTRUMENTO']
ativos_f5c = ativos_f5b[ativos_f5b.nameactiontype != 'AGRAVO DE PETIÇÃO']
ativos_f5d = ativos_f5c[ativos_f5c.nameactiontype != 'CARTA DE SENTENÇA']
ativos_f5e = ativos_f5d[ativos_f5d.nameactiontype != 'CARTA PRECATÓRIA']
ativos_f5g = ativos_f5e[ativos_f5e.nameactiontype != 'EXECUÇÃO PROVISÓRIA']
ativos_f5h = ativos_f5g[ativos_f5g.nameactiontype != 'MANDADO DE SEGURANÇA']
ativos_f5i = ativos_f5h[ativos_f5h.nameactiontype != 'PRODUÇÃO ANTECIPADA DE PROVAS']
ativos_f5j = ativos_f5i[ativos_f5i.nameactiontype != 'PROSPECT']
ativos_f5k = ativos_f5j[ativos_f5j.nameactiontype != 'TESTE APP']

#eliminar duplicadas se houver duplicadas nas 3 colunas ao mesmo tempo
ativos_f6 = ativos_f5k.drop_duplicates(subset=["n_processo","nameclient","namefolder"], keep="first")
ativos_f7 = ativos_f6.drop_duplicates(subset=["namefolder"], keep="first")

# Aplica o selo Status = Ativo
ativos_f7['status'] = "Ativo"

ativos = ativos_f7


##############
# ENCERRADOS #
##############

# cria a coluna 'temp' com os ativos=True, dentro da base
base['temp'] = ativos['namefolder'].isin(base['namefolder'])

# exclui aqueles que são ativos
enc_f1 = base[base['temp'] != True]

# deleta a coluna 'temp'
enc_f1 = enc_f1.drop(columns='temp')

# exclui prospect da coluna namefolder e da coluna namephase
enc_f2 = enc_f1[~enc_f1.namefolder.str.match(r'\.*PROS\.*', case=True)]
enc_f2 = enc_f2[enc_f2.namephase != 'PROSPECT']

# Exclui os seguintes termos da coluna nameactiontype - OBS: em algumas exceções o MS é processo principal e não estão considerados nesse script
enc_f2b = enc_f2[enc_f2.nameactiontype != 'AGRAVO DE INSTRUMENTO']
enc_f2c = enc_f2b[enc_f2b.nameactiontype != 'AGRAVO DE PETIÇÃO']
enc_f2d = enc_f2c[enc_f2c.nameactiontype != 'CARTA DE SENTENÇA']
enc_f2e = enc_f2d[enc_f2d.nameactiontype != 'CARTA PRECATÓRIA']
enc_f2g = enc_f2e[enc_f2e.nameactiontype != 'EXECUÇÃO PROVISÓRIA']
enc_f2h = enc_f2g[enc_f2g.nameactiontype != 'MANDADO DE SEGURANÇA']
enc_f2i = enc_f2h[enc_f2h.nameactiontype != 'PRODUÇÃO ANTECIPADA DE PROVAS']
enc_f2j = enc_f2i[enc_f2i.nameactiontype != 'PROSPECT']
enc_f2k = enc_f2j[enc_f2j.nameactiontype != 'TESTE APP']

# Elimina pastas duplicadas
enc_f3 = enc_f2k.drop_duplicates(subset=["namefolder"], keep="first")

# Aplica o selo Status = Encerrado
enc_f3['status'] = "Encerrado"

encerrados = enc_f3

#########
# ERROS #
#########

# ERRO da coluna motivo_encerramento
erros = base[base.closereason =='ERRO']

# Elimina pastas duplicadas
erros = erros.drop_duplicates(subset=["namefolder"], keep="first")

# Aplica o selo Status = Encerrado
erros['status'] = "Erro de Registro"





##########################
# FINALIZA COLUNA STATUS #
##########################

# encerrados + reativados
col_status = pd.concat([encerrados,reativados],ignore_index=True)

# Exclui colunas desnecessárias
col_status_f1 = col_status.drop(columns=['number','cnjnumber','createdate'])

# Aqui os Reativados também estão como Encerrados. Eliminar os Encerrados
col_status_f2 = col_status_f1.drop_duplicates(subset=["namefolder"], keep="last")

# Adiciona os ativos, pois estava dando erro antecipar essa etapa
col_status_f3 = pd.concat([col_status_f2,ativos],ignore_index=True)

# Adiciona os erros
col_status_f4 = pd.concat([col_status_f3,erros],ignore_index=True)

# Exclui se contiver CP|MS|AP|CS em n_processo
col_status_f5 = col_status_f4[~col_status_f4.n_processo.str.match(r'CP|MS|AP|CS', case=True)]

# Aqui há algumas pastas ativas, reativadas e encerradas ao mesmo tempo. Eliminar os Encerrados e Reativados duplicados
col_status_f6 = col_status_f5.drop_duplicates(subset=["namefolder"], keep="last")

# Remove se contive Judice Office no nameclient
col_status_f7 = col_status_f6[col_status_f6['nameclient']!='Judice Office']


base = col_status_f7

#########################
# ADICIONA OS PROSPECTS # Seleciona os prospects que não cairam em nenhum filtro/selo
######################### For the sake of continuity

pros = format_f1
# Seleciona todos os prospects que têm PROSPECT em namephase
pros_f1 = pros[pros.namephase == 'PROSPECT']
# Cria a coluna temp com os que tem a coluna status preenchina = true
pros_f1['temp'] = base['namefolder'].isin(pros_f1['namefolder'])
# Seleciona os que sobraram
pros_f2 = pros_f1[pros_f1['temp'] != True]
#Deleta os duplicados
pros_f3 = pros_f2.drop_duplicates(subset=["namefolder"], keep="first")
# Deleta a coluna Temp
pros_f4 = pros_f3.drop(columns='temp')
# Aplica o selo Status = Prospect
pros_f4['status'] = "Prospect"

# Adiciona os prospects no STATUS
col_status_f8 = pd.concat([col_status_f7,pros_f4],ignore_index=True)


base = col_status_f8





###############
# COLUNA RAMO #
###############

ramo = base

# REPLACE NaTs e nan
ramo = ramo.replace(np.nan, '', regex=True)

# Filtros Gerais
ramo.loc[ramo.nameparticipant.str.contains("BANCO|CAIXA|CEF|BCO|BANK|HSBC|BANRISUL|SANTANDER|BRADESCO|BANESPA|CORRETORA|INVESTIMENTO|SEGURADORA|FINANCEIR|COOPERATIVA|ORBRAL|CCB|SEGURO"),'ramo'] = "Bancário"
ramo.loc[ramo.nameparticipant.str.contains("INSS|PETROS|PREV|IPERGS|UNIMED|POLICIA|MULTIBENEFICIOS|ASSESSORIA|ATENDIMENTO|TRANSP|SERVICE|HUMANO|TERCEIRI|PARTICIPA|COMUNICA|TELEPERFORMANCE|ADOBE|PROMOCIA|PROMIL|ADMINISTRA"),'ramo'] = "Outros Ramos"
# Filtro Específico
ramo.loc[ramo.nameparticipant.str.contains("BANCO DO BRASIL S.A E PREVI|CREDIMATONE|BRADESCO SEGUROS|BRADESCO VIDA|HSBC|BMG|IBI PROMOTORA|ITAU|ITAÚ|BGN MERCANTIL|CREFISA|CRAFISA|ALLIS HIPERCARD|FINASA|PROSEG|BRADESCO|SALUTE ADM|UNICRED"),'ramo'] = "Bancário"

# Preenche vazios com 'Não Bancário'
ramo['ramo'] = ramo['ramo'].fillna('Outros Ramos') 

base = ramo


####################
# COLUNA DEMORA AJ #
####################

demora_aj = base

# Seleciona as linhas que tem valor vazio na distributiondate
demora_aj_f1a = demora_aj[demora_aj['distributiondate']=='']
#Resto
demora_aj_f1b = demora_aj[demora_aj['distributiondate']!='']

# Coloca a data do encerramento nessas linhas vazias - isso será desfeito mais a frente
demora_aj_f1a['distributiondate'] = demora_aj_f1a['closedatefolder']

#Ainda sobraram linhas vazias
# Seleciona as linhas que ainda tem valor vazio na distributiondate
demora_aj_f2a = demora_aj_f1a[demora_aj_f1a['distributiondate']=='']
#Resto
demora_aj_f2b = demora_aj_f1a[demora_aj_f1a['distributiondate']!='']

# Coloca a data de hoje nessas linhas vazias - isso será desfeito mais a frente
demora_aj_f2a['distributiondate'] = pd.Timestamp.today()

# Converte para formato de data
demora_aj_f2a['distributiondate'] = pd.to_datetime(demora_aj_f2a['distributiondate'], format='%Y-%m-%d').dt.date
demora_aj_f2a['data_abertura'] = pd.to_datetime(demora_aj_f2a['data_abertura'], format='%Y-%m-%d').dt.date

# Calcula a diferença
demora_aj_f2a['demora_aj_meses'] = demora_aj_f2a['distributiondate'] - demora_aj_f2a['data_abertura']

# Converte para quantidade de meses
demora_aj_f2a['demora_aj_meses'] = demora_aj_f2a.demora_aj_meses.astype("timedelta64[D]")/30

# Desfaz as alterações na distributiondate que fizemos anteriormente
demora_aj_f2a['distributiondate'] = ""

# Junta as duas tabelas separadas
demora_aj_f1a = pd.concat([demora_aj_f2a,demora_aj_f2b],ignore_index=True)

# Seleciona as que não tinham distributiondate vazio
# Converte para formato de data
demora_aj_f1b['distributiondate'] = pd.to_datetime(demora_aj_f1b['distributiondate'], format='%Y-%m-%d').dt.date
demora_aj_f1b['data_abertura'] = pd.to_datetime(demora_aj_f1b['data_abertura'], format='%Y-%m-%d').dt.date

# Calcula a diferença
demora_aj_f1b['demora_aj_meses'] = demora_aj_f1b['distributiondate'] - demora_aj_f1b['data_abertura']

# Converte para quantidade de meses
demora_aj_f1b['demora_aj_meses'] = demora_aj_f1b.demora_aj_meses.astype("timedelta64[D]")/30

# Junta as duas tabelas
demora_aj = pd.concat([demora_aj_f1a,demora_aj_f1b],ignore_index=True)

# REPLACE NaTs e nan
demora_aj['demora_aj_meses'] = demora_aj['demora_aj_meses'].replace(np.nan, '', regex=True)

# Formata o número - troca o ponto por vírgula
demora_aj['demora_aj_meses'] = demora_aj['demora_aj_meses'].astype(str)
demora_aj['demora_aj_meses'] = demora_aj['demora_aj_meses'].str.replace(".", ",")

# Forma a Base
base = demora_aj


#####################
# COLUNA DEMORA REQ #
#####################

demora_req = base

# Seleciona as linhas da area Previdenciária e as que não são
demora_req_f1a = demora_req[demora_req['namearea']=='PREVIDENCIÁRIO']
demora_req_f1b = demora_req[demora_req['namearea']!='PREVIDENCIÁRIO']

# Seleciona os processos Ativos ou Reativados do Prev
demora_req_f2a = demora_req_f1a.loc[demora_req_f1a.status.str.contains("Ativo|Reativado")]
demora_req_f2b = demora_req_f1a.loc[demora_req_f1a.status.str.contains("Encerrado")]

# Seleciona as linhas que tem valor vazio na data_requerimento do Prev At/Rat
demora_req_f3a = demora_req_f2a[demora_req_f2a['date_requerimento']==''] 
demora_req_f3b = demora_req_f2a[demora_req_f2a['date_requerimento']!=''] 

# Coloca a data de hoje nessas linhas vazias - isso será desfeito mais a frente
demora_req_f3a['date_requerimento'] = pd.Timestamp.today()

# Converte para formato de data
demora_req_f3a['date_requerimento'] = pd.to_datetime(demora_req_f3a['date_requerimento'], format='%Y-%m-%d').dt.date
demora_req_f3a['data_abertura'] = pd.to_datetime(demora_req_f3a['data_abertura'], format='%Y-%m-%d').dt.date

# Calcula a diferença
demora_req_f3a['demora_req_meses'] = demora_req_f3a['date_requerimento'] - demora_req_f3a['data_abertura']

# Converte para quantidade de meses
demora_req_f3a['demora_req_meses'] = demora_req_f3a.demora_req_meses.astype("timedelta64[D]")/30

# Desfaz as alterações na distributiondate que fizemos anteriormente
demora_req_f3a['date_requerimento'] = ""

# Junta as tabelas que foram separadas
demora_req_f2a = pd.concat([demora_req_f3a,demora_req_f3b],ignore_index=True)

# Junta as tabelas que foram separadas
demora_req_f1a = pd.concat([demora_req_f2a,demora_req_f2b],ignore_index=True)

# Converte para formato de data
demora_req_f1a['date_requerimento'] = pd.to_datetime(demora_req_f1a['date_requerimento'], format='%Y-%m-%d').dt.date
demora_req_f1a['data_abertura'] = pd.to_datetime(demora_req_f1a['data_abertura'], format='%Y-%m-%d').dt.date

# Calcula a diferença
demora_req_f1a['demora_req_meses'] = demora_req_f1a['date_requerimento'] - demora_req_f1a['data_abertura']

# Converte para quantidade de meses
demora_req_f1a['demora_req_meses'] = demora_req_f1a.demora_req_meses.astype("timedelta64[D]")/30

# Concat as tabelas que foram separadas
demora_req = pd.concat([demora_req_f1a,demora_req_f1b],ignore_index=True)
 
# REPLACE NaTs e nan
demora_req['demora_req_meses'] = demora_req['demora_req_meses'].replace(np.nan, '', regex=True)

# Formata o número - troca o ponto por vírgula
demora_req['demora_req_meses'] = demora_req['demora_req_meses'].astype(str)
demora_req['demora_req_meses'] = demora_req['demora_req_meses'].str.replace(".", ",")

# Refaz a base
base = demora_req


####################
# COLUNA DECORRIDO #
####################

decorrido = base

# Seleciona os que não tem data de encerramento
decorrido_f1a = decorrido[decorrido['closedatefolder']==''] 
#Resto
decorrido_f1b = decorrido[decorrido['closedatefolder']!=''] 

# Coloca a data de hoje nessas linhas vazias - isso será desfeito mais a frente
decorrido_f1a['closedatefolder'] = pd.Timestamp.today()

# Converte para formato de data
decorrido_f1a['closedatefolder'] = pd.to_datetime(decorrido_f1a['closedatefolder'], format='%Y-%m-%d').dt.date
decorrido_f1a['data_abertura'] = pd.to_datetime(decorrido_f1a['data_abertura'], format='%Y-%m-%d').dt.date

# Calcula a diferença
decorrido_f1a['decorrido_meses'] = decorrido_f1a['closedatefolder'] - decorrido_f1a['data_abertura']

# Converte para quantidade de meses
decorrido_f1a['decorrido_meses'] = decorrido_f1a.decorrido_meses.astype("timedelta64[D]")/30

# Desfaz as alterações na data_encerramento que fizemos anteriormente
decorrido_f1a['closedatefolder'] = ""

# Agora calcula a diferença dos que tinham data de encerramento
# Converte para formato de data
decorrido_f1b['closedatefolder'] = pd.to_datetime(decorrido_f1b['closedatefolder'], format='%Y-%m-%d').dt.date
decorrido_f1b['data_abertura'] = pd.to_datetime(decorrido_f1b['data_abertura'], format='%Y-%m-%d').dt.date

#Calcula
decorrido_f1b['decorrido_meses'] = decorrido_f1b['closedatefolder'] - decorrido_f1b['data_abertura']

# Converte para quantidade de meses
decorrido_f1b['decorrido_meses'] = decorrido_f1b.decorrido_meses.astype("timedelta64[D]")/30

# Junta as tabelas que foram separadas
decorrido = pd.concat([decorrido_f1a,decorrido_f1b],ignore_index=True)

# REPLACE NaTs e nan
decorrido['decorrido_meses'] = decorrido['decorrido_meses'].replace(np.nan, '', regex=True)

# Formata o número - troca o ponto por vírgula
decorrido['decorrido_meses'] = decorrido['decorrido_meses'].astype(str)
decorrido['decorrido_meses'] = decorrido['decorrido_meses'].str.replace(".", ",")

base = decorrido


##################
# SAÍDA DATALAKE #
##################

xdata_out = base

# Em Unidade = Substitui Caxias do Sul e Passo Fundo por Porto Alegre
xdata_out['unidade'] = xdata_out['unidade'].replace("Caxias do Sul","Porto Alegre", regex=True)
xdata_out['unidade'] = xdata_out['unidade'].replace("Passo Fundo","Porto Alegre", regex=True)

# REPLACE NaTs e nan = Isso altera o type de algumas colunas
xdata_out = xdata_out.replace(np.nan, '', regex=True)

# Renomeia colunas
xdata_out.rename(columns={'namefolder':'pasta','namearea':'area', 'nameactiontype':'tipo_de_acao','namephase':'fase','nameclient':'cliente','distributiondate':'data_ajuizamento','nameparticipant':'parte','reativacao_date':'data_reativacao','date_requerimento':'data_requerimento','closereason':'motivo_encerramento','closedate':'data_encerramento_processo','closedatefolder':'data_encerramento_pasta','emailclient':'email'}, inplace=True)

# escolhe as colunas da saída
xdata_out_dl = xdata_out[['n_processo','pasta','cliente','email','unidade','area','ramo','tipo_de_acao','fase','parte','motivo_encerramento','data_abertura','data_encerramento_processo','data_encerramento_pasta','data_reativacao','data_requerimento','data_ajuizamento','status','demora_aj_meses','demora_req_meses','decorrido_meses']]



##################
# TB CALC LINEAR #
##################


# A fonte é o CSV do primeiro python == # 
base = xdata_out_dl
            
base = base.replace(np.nan, 0, regex=True)

# Primeiro tem que converter para string
base['data_abertura'] = base['data_abertura'].astype(str)
base['data_encerramento_pasta'] = base['data_encerramento_pasta'].astype(str)

#Abertura é +1, encerramento é -1 e null é 0
base['data_abertura_n'] = np.where(base['data_abertura'] == "0", 0, 1)
base['data_encerramento_pasta_n'] = np.where(base['data_encerramento_pasta'] == "0", 0, -1)


############
## BLOCO 1 = TRABALHISTA + BANCÁRIO = conta_banc
############
bloco_1 = base

#Filtra
bloco_1 = bloco_1[bloco_1.area == 'TRABALHISTA']
bloco_1 = bloco_1[bloco_1.ramo == 'Bancário']

#Agrupa pela data
bloco_1_ab = bloco_1.groupby('data_abertura')['data_abertura_n'].agg('sum').reset_index()
bloco_1_ab = bloco_1_ab.rename(columns={'data_abertura_n': "result", 'data_abertura':'data'})

bloco_1_enc = bloco_1.groupby('data_encerramento_pasta')['data_encerramento_pasta_n'].agg('sum').reset_index()
bloco_1_enc = bloco_1_enc.rename(columns={'data_encerramento_pasta_n': "result",'data_encerramento_pasta':'data'})
#Combina os agrupamentos
bloco_1 = pd.concat([bloco_1_ab,bloco_1_enc],ignore_index=True)
# Agrupa os combinados
bloco_1 = bloco_1.groupby('data')['result'].agg('sum').reset_index()

bloco_1 = bloco_1.rename(columns={'result': "conta_banc"})



#############
## BLOCO 2 ## = TRABALHISTA + OUTROS RAMOS = conta_or
#############

bloco_2 = base

#Filtra
bloco_2 = bloco_2[bloco_2.area == 'TRABALHISTA']
bloco_2 = bloco_2[bloco_2.ramo == 'Outros Ramos']

#Agrupa pela data
bloco_2_ab = bloco_2.groupby('data_abertura')['data_abertura_n'].agg('sum').reset_index()
bloco_2_ab = bloco_2_ab.rename(columns={'data_abertura_n': "result", 'data_abertura':'data'})

bloco_2_enc = bloco_2.groupby('data_encerramento_pasta')['data_encerramento_pasta_n'].agg('sum').reset_index()
bloco_2_enc = bloco_2_enc.rename(columns={'data_encerramento_pasta_n': "result",'data_encerramento_pasta':'data'})
#Combina os agrupamentos
bloco_2 = pd.concat([bloco_2_ab,bloco_2_enc],ignore_index=True)
# Agrupa os combinados
bloco_2 = bloco_2.groupby('data')['result'].agg('sum').reset_index()

bloco_2 = bloco_2.rename(columns={'result': "conta_or"})



#############
## BLOCO 3 = PREVIDENCIÁRIO + POA = conta_ppoa
#############

bloco_3 = base

#Filtra
bloco_3 = bloco_3[bloco_3.area == 'PREVIDENCIÁRIO']
bloco_3 = bloco_3[bloco_3.unidade == 'Porto Alegre']

#Agrupa pela data
bloco_3_ab = bloco_3.groupby('data_abertura')['data_abertura_n'].agg('sum').reset_index()
bloco_3_ab = bloco_3_ab.rename(columns={'data_abertura_n': "result", 'data_abertura':'data'})

bloco_3_enc = bloco_3.groupby('data_encerramento_pasta')['data_encerramento_pasta_n'].agg('sum').reset_index()
bloco_3_enc = bloco_3_enc.rename(columns={'data_encerramento_pasta_n': "result",'data_encerramento_pasta':'data'})
#Combina os agrupamentos
bloco_3 = pd.concat([bloco_3_ab,bloco_3_enc],ignore_index=True)
# Agrupa os combinados
bloco_3 = bloco_3.groupby('data')['result'].agg('sum').reset_index()

bloco_3 = bloco_3.rename(columns={'result': "conta_ppoa"})


#############
## BLOCO 4 = CIVEL = conta_cvl
#############

bloco_4 = base

#Filtra
bloco_4 = bloco_4[bloco_4.area == 'CÍVEL']

#Agrupa pela data
bloco_4_ab = bloco_4.groupby('data_abertura')['data_abertura_n'].agg('sum').reset_index()
bloco_4_ab = bloco_4_ab.rename(columns={'data_abertura_n': "result", 'data_abertura':'data'})

bloco_4_enc = bloco_4.groupby('data_encerramento_pasta')['data_encerramento_pasta_n'].agg('sum').reset_index()
bloco_4_enc = bloco_4_enc.rename(columns={'data_encerramento_pasta_n': "result",'data_encerramento_pasta':'data'})
#Combina os agrupamentos
bloco_4 = pd.concat([bloco_4_ab,bloco_4_enc],ignore_index=True)
# Agrupa os combinados
bloco_4 = bloco_4.groupby('data')['result'].agg('sum').reset_index()

bloco_4 = bloco_4.rename(columns={'result': "conta_cvl"})


#############
## BLOCO 5 = INDENIZATORIO = conta_ind
#############

bloco_5 = base

#Filtra
bloco_5 = bloco_5[bloco_5.area == 'INDENIZATÓRIA']

#Agrupa pela data
bloco_5_ab = bloco_5.groupby('data_abertura')['data_abertura_n'].agg('sum').reset_index()
bloco_5_ab = bloco_5_ab.rename(columns={'data_abertura_n': "result", 'data_abertura':'data'})

bloco_5_enc = bloco_5.groupby('data_encerramento_pasta')['data_encerramento_pasta_n'].agg('sum').reset_index()
bloco_5_enc = bloco_5_enc.rename(columns={'data_encerramento_pasta_n': "result",'data_encerramento_pasta':'data'})
#Combina os agrupamentos
bloco_5 = pd.concat([bloco_5_ab,bloco_5_enc],ignore_index=True)
# Agrupa os combinados
bloco_5 = bloco_5.groupby('data')['result'].agg('sum').reset_index()

bloco_5 = bloco_5.rename(columns={'result': "conta_ind"})


#############
## BLOCO 6 = PREVIDENCIARIO + SP = conta_prevsp
#############
bloco_6 = base

#Filtra
bloco_6 = bloco_6[bloco_6.area == 'PREVIDENCIÁRIO']
bloco_6 = bloco_6[bloco_6.unidade == 'São Paulo']

#Agrupa pela data
bloco_6_ab = bloco_6.groupby('data_abertura')['data_abertura_n'].agg('sum').reset_index()
bloco_6_ab = bloco_6_ab.rename(columns={'data_abertura_n': "result", 'data_abertura':'data'})

bloco_6_enc = bloco_6.groupby('data_encerramento_pasta')['data_encerramento_pasta_n'].agg('sum').reset_index()
bloco_6_enc = bloco_6_enc.rename(columns={'data_encerramento_pasta_n': "result",'data_encerramento_pasta':'data'})
#Combina os agrupamentos
bloco_6 = pd.concat([bloco_6_ab,bloco_6_enc],ignore_index=True)
# Agrupa os combinados
bloco_6 = bloco_6.groupby('data')['result'].agg('sum').reset_index()

bloco_6 = bloco_6.rename(columns={'result': "conta_prevsp"})



#############
## BLOCO 7 = BANCARIO + POA = conta_banc_poa
#############
bloco_7 = base

#Filtra
bloco_7 = bloco_7[bloco_7.unidade == 'Porto Alegre']
bloco_7 = bloco_7[bloco_7.ramo == 'Bancário']

#Agrupa pela data
bloco_7_ab = bloco_7.groupby('data_abertura')['data_abertura_n'].agg('sum').reset_index()
bloco_7_ab = bloco_7_ab.rename(columns={'data_abertura_n': "result", 'data_abertura':'data'})

bloco_7_enc = bloco_7.groupby('data_encerramento_pasta')['data_encerramento_pasta_n'].agg('sum').reset_index()
bloco_7_enc = bloco_7_enc.rename(columns={'data_encerramento_pasta_n': "result",'data_encerramento_pasta':'data'})
#Combina os agrupamentos
bloco_7 = pd.concat([bloco_7_ab,bloco_7_enc],ignore_index=True)
# Agrupa os combinados
bloco_7 = bloco_7.groupby('data')['result'].agg('sum').reset_index()

bloco_7 = bloco_7.rename(columns={'result': "conta_banc_poa"})



#############
## BLOCO 8 = BANCARIO + SP = conta_banc_sp
#############

bloco_8 = base

#Filtra
bloco_8 = bloco_8[bloco_8.unidade == 'São Paulo']
bloco_8 = bloco_8[bloco_8.ramo == 'Bancário']

#Agrupa pela data
bloco_8_ab = bloco_8.groupby('data_abertura')['data_abertura_n'].agg('sum').reset_index()
bloco_8_ab = bloco_8_ab.rename(columns={'data_abertura_n': "result", 'data_abertura':'data'})

bloco_8_enc = bloco_8.groupby('data_encerramento_pasta')['data_encerramento_pasta_n'].agg('sum').reset_index()
bloco_8_enc = bloco_8_enc.rename(columns={'data_encerramento_pasta_n': "result",'data_encerramento_pasta':'data'})
#Combina os agrupamentos
bloco_8 = pd.concat([bloco_8_ab,bloco_8_enc],ignore_index=True)
# Agrupa os combinados
bloco_8 = bloco_8.groupby('data')['result'].agg('sum').reset_index()

bloco_8 = bloco_8.rename(columns={'result': "conta_banc_sp"})


#####################
# SAIDA CALC LINEAR #
#####################


# concatena todos os blocos
xdata_out_tbl = pd.concat([bloco_1,bloco_2,bloco_3,bloco_4,bloco_5,bloco_6,bloco_7,bloco_8],ignore_index=True)
# agrupa por data
xdata_out_tbl = xdata_out_tbl.groupby('data')['conta_banc','conta_or','conta_ppoa','conta_cvl','conta_ind','conta_prevsp','conta_banc_poa','conta_banc_sp'].sum().reset_index()


xdata_out_tbl = xdata_out_tbl[xdata_out_tbl['data'] >= "2019-01-01"]



###############
# INDICE IPCA # >> BUSCA NA API DO BANCO CENTRAL
###############

df = pd.read_csv("http://api.bcb.gov.br/dados/serie/bcdata.sgs.433/dados?formato=csv", delimiter=";", encoding = "UTF-8") 

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


#####>>> CRIA CSVs

xdata_out_ipca_idx.to_csv('C:/xampp/htdocs/dashboard/datalake/ipca_idx.csv', index=False)

xdata_out_tbl.to_csv('C:/xampp/htdocs/dashboard/datalake/tb_calc_linear.csv', index=False)

xdata_out_dl.to_csv('C:/xampp/htdocs/dashboard/datalake/datalake.csv', index=False)



##############
# DICTIONARY # FAZER UM PARA CADA CSV?
##############

#body = {}
#body['data'] = xdata_out_dl.to_dict("records")