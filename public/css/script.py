f = open('./public/css/mdb-pro.scss', 'rt')

lines = f.readlines()

f.close()

result = ""
count = 0

for line in lines:
	count += 1
	if count % 2 == 0:
		continue
	temp = line.strip()
	if '{' in temp or '}' in temp or "" == temp or temp[len(temp) - 1] == ',':
		result += temp + "\n"
	else:
		if ';' in temp:
			result += "\t" + temp + "\n"
		else:
			result += "\t" + temp + ";\n"

f = open('./public/css/mdb-pro.scss', 'wt')
f.write(result)
f.close()
