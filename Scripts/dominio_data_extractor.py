# coding=utf-8
import csv
import MySQLdb
import random
from key import KEY

# Conecta ao banco de dados
connection = MySQLdb.connect("localhost", "root", KEY, "multas_rodovias_federais")
cursor = connection.cursor()

# Variáveis necessárias
cnh_types = ['A', 'A', 'B', 'B', 'C', 'D']
DDD = ['11', '12', '13', '14', '15', '16', '17', '18', '19', '21', '22', '24', '27', '28', '31', '32', '33', '34', 
'35', '37', '38', '41', '42', '43', '44', '45', '46', '47', '48', '49', '51', '53', '54', '55', '61', '62', '63', 
'64', '65', '66', '67', '68', '69', '71', '73', '74', '75', '77', '79', '81', '82', '83', '84', '85', '86', '87', 
'88', '89', '91', '92', '93', '94', '95', '96', '97', '98', '99']
prefixo_celular = ['96', '97', '98', '99', '91', '92', '93', '94', '87', '88', '81', '82', '83', '84', '85', '86']
prefixo_residencial = ['30', '31', '32', '34', '35' ,'36', '40', '41', '42', '43', '44', '45']
tipos_telefones = ['Residencial', 'Comercial', 'Celular']
telefones = [0, 1, 1, 1, 2]
auto_infracao = []
condutor = []
data = []
names_list = []
surnames_list = []

# Função que cria os telefones da tabela
def create_phones(cod_condutor):
	for x in xrange(0, random.choice(telefones)):
		# Código local
		cod_local = random.choice(DDD)

		# Tipo de telefone
		tipo = random.choice(tipos_telefones)
		if(tipo == 'Residencial' or tipo == 'Comercial'):
			telefone = random.choice(prefixo_residencial)
		else:
			telefone = random.choice(prefixo_celular)

		# Gera o telefone
		telefone = telefone +  '{0:06d}'.format(random.randrange(0, 999999))
		cursor.execute("""INSERT INTO tbl_telefones (num_telefone, cod_local) VALUES (%s, %s)""", (telefone, cod_local))

		#Pega última id usada
		cursor.execute("""SELECT LAST_INSERT_ID()""")
		last_id = cursor.fetchone()

		# Liga telefone e condutor
		cursor.execute("""INSERT INTO tbl_condutor_tem_telefones VALUES (%s, %s, %s)""", (cod_condutor, last_id[0], tipo))

# Cria tabela de gravidades
print "Criando tabela de gravidades de infrações"
file = open('gravidade_infracao.csv')
gravidades = csv.reader(file, delimiter=";")
next(gravidades)
for row in gravidades:
	cursor.execute("""INSERT INTO tbl_gravidade_infracao VALUES (%s, %s, %s)""", (row[0], row[1], row[2].decode('cp1252')))

connection.commit()

#Cria tabela de infrações
print "Criando tabela de infrações"
file = open('tbl_infracao.csv')
infracoes = csv.reader(file, delimiter=";")
next(infracoes)
for row in infracoes:
	if row[5] != '0':
		cursor.execute("""INSERT INTO tbl_infracao VALUES (%s, %s, %s, %s)""", (row[0], row[1].decode('cp1252'), row[5], row[4]))

connection.commit()

# Cria lista a partir de arquivo com nomes
file = open('nomes.csv')
names = csv.reader(file, delimiter="\n")
for line in names:
	names_list.append(line[0])

# Cria lista a partir de arquivo com sobrenomes
file = open('sobrenomes.csv')
surnames = csv.reader(file, delimiter="\n")
for line in surnames:
	surnames_list.append(line[0])

# Cria a tabela de condutores
print "Criando tabela de condutores infratores/telefones 2007/1"
file = open('2007_1_inf.csv')
condutor_infrator = csv.reader(file, delimiter=";")
next(condutor_infrator)
for row in condutor_infrator:
	condutor.append(row[0])
	auto_infracao.append(row[1])
	data.append(row[2])

	try:
		cursor.execute("""INSERT INTO tbl_condutor VALUES (%s, %s, %s, %s)""", 
			(row[0], random.choice(names_list), random.choice(surnames_list), random.choice(cnh_types)))

		# Cria telefone para condutor
		create_phones(row[0])
	except:
		continue

connection.commit()

# Cria tabela de multas
print "Criando tabela de multas 2007/1"
file = open('2007_1_multas.csv')
multas = csv.reader(file, delimiter=";")
next(multas)
for row in multas:
	if(len(auto_infracao) > 0):
		if(auto_infracao[0] == row[3]):
			try:
				cursor.execute("""INSERT INTO tbl_multa VALUES (%s, %s, %s, %s)""", (row[3], row[5], condutor[0], data[0]))
			except:
				cursor.execute("""DELETE FROM tbl_condutor WHERE cod_condutor=%s""", (condutor[0]))
			finally:
				auto_infracao.pop(0)
				condutor.pop(0)
				data.pop(0)
	else:
		break

connection.commit()

# Cria a tabela de condutores
print "Criando tabela de condutores infratores/telefones 2007/2"
file = open('2007_2_inf.csv')
condutor_infrator = csv.reader(file, delimiter=";")
next(condutor_infrator)
for row in condutor_infrator:
	condutor.append(row[0])
	auto_infracao.append(row[1])
	data.append(row[2])

	try:
		cursor.execute("""INSERT INTO tbl_condutor VALUES (%s, %s, %s, %s)""", 
			(row[0], random.choice(names_list), random.choice(surnames_list), random.choice(cnh_types)))

		# Cria telefone para condutor
		create_phones(row[0])
	except:
		continue

connection.commit()

# Cria tabela de multas
print "Criando tabela de multas 2007/2"
file = open('2007_2_multas.csv')
multas = csv.reader(file, delimiter="|")
next(multas)
for row in multas:
	if(len(auto_infracao) > 0):
		if(auto_infracao[0] == row[3]):
			try:
				cursor.execute("""INSERT INTO tbl_multa VALUES (%s, %s, %s, %s)""", (row[3], row[5], condutor[0], data[0]))
			except:
				cursor.execute("""DELETE FROM tbl_condutor WHERE cod_condutor=%s""", (condutor[0]))
			finally:
				auto_infracao.pop(0)
				condutor.pop(0)
				data.pop(0)
	else:
		break

connection.commit()

# Cria a tabela de condutores
print "Criando tabela de condutores infratores/telefones 2008/1"
file = open('2008_1_inf.csv')
condutor_infrator = csv.reader(file, delimiter=";")
next(condutor_infrator)
for row in condutor_infrator:
	condutor.append(row[0])
	auto_infracao.append(row[1])
	data.append(row[2])

	try:
		cursor.execute("""INSERT INTO tbl_condutor VALUES (%s, %s, %s, %s)""", 
			(row[0], random.choice(names_list), random.choice(surnames_list), random.choice(cnh_types)))

		# Cria telefone para condutor
		create_phones(row[0])
	except:
		continue

connection.commit()

# Cria tabela de multas
print "Criando tabela de multas 2008/1"
file = open('2008_1_multas.csv')
multas = csv.reader(file, delimiter="|")
next(multas)
for row in multas:
	if(len(auto_infracao) > 0):
		if(auto_infracao[0] == row[3]):
			try:
				cursor.execute("""INSERT INTO tbl_multa VALUES (%s, %s, %s, %s)""", (row[3], row[5], condutor[0], data[0]))
			except:
				cursor.execute("""DELETE FROM tbl_condutor WHERE cod_condutor=%s""", (condutor[0]))
			finally:
				auto_infracao.pop(0)
				condutor.pop(0)
				data.pop(0)
	else:
		break

connection.commit()

# Cria a tabela de condutores
print "Criando tabela de condutores infratores/telefones 2008/2"
file = open('2008_2_inf.csv')
condutor_infrator = csv.reader(file, delimiter=";")
next(condutor_infrator)
for row in condutor_infrator:
	condutor.append(row[0])
	auto_infracao.append(row[1])
	data.append(row[2])

	try:
		cursor.execute("""INSERT INTO tbl_condutor VALUES (%s, %s, %s, %s)""", 
			(row[0], random.choice(names_list), random.choice(surnames_list), random.choice(cnh_types)))

		# Cria telefone para condutor
		create_phones(row[0])
	except:
		continue

connection.commit()

# Cria tabela de multas
print "Criando tabela de multas 2008/2"
file = open('2008_2_multas.csv')
multas = csv.reader(file, delimiter="|")
next(multas)
for row in multas:
	if(len(auto_infracao) > 0):
		if(auto_infracao[0] == row[3]):
			try:
				cursor.execute("""INSERT INTO tbl_multa VALUES (%s, %s, %s, %s)""", (row[3], row[5], condutor[0], data[0]))
			except:
				cursor.execute("""DELETE FROM tbl_condutor WHERE cod_condutor=%s""", (condutor[0]))
			finally:
				auto_infracao.pop(0)
				condutor.pop(0)
				data.pop(0)
	else:
		break

connection.commit()

# Cria telefones repetidos
print "Criando telefones repetidos"
cursor.execute("""SELECT cod_telefone, tipo_telefone FROM tbl_condutor_tem_telefones ORDER BY RAND() LIMIT 30""")
telefones = cursor.fetchall()
cursor.execute("""SELECT cod_condutor FROM tbl_condutor ORDER BY RAND() LIMIT 20""")
condutores = cursor.fetchall()

for condutor, telefone in zip(condutores, telefones):
	cursor.execute("""INSERT INTO tbl_condutor_tem_telefones VALUES (%s, %s, %s)""", (condutor[0], telefone[0], telefone[1]))

connection.commit()

connection.close()


