
wget and sed must be installed before running `make up`

make up

# Navegador

Listar clientes:
http://localhost/clientes

Listar contas do cliente 101:
http://localhost/contas/101

Exibir informações da conta 5001:
http://localhost/conta/5001

# Bash
wget -qc -O - http://localhost/clientes.json
wget -qc -O - http://localhost/contas.json/101
wget -qc -O - http://localhost/conta.json/5001

Operações:

Depositar na conta 5001:
wget -qc -O - http://localhost/api/depositar --method=POST --body-data="conta=5001&valor=15000"

Sacar da conta 5001:
wget -qc -O - http://localhost/api/sacar --method=POST --body-data="conta=5001&valor=1500.50"

Criar cliente:
wget -qc -O - http://localhost/api/cliente --method=PUT --body-data="nome=Fulano de Tal"

Criar conta para cliente 105:
wget -qc -O - http://localhost/api/conta --method=PUT --body-data="cliente=105"

