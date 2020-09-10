
### Baixar solução:
`git clone git@github.com:nandoabreu/banco-laravel.git`


### Levantar os serviços:
__wget__ e __sed__ devem estar instalado antes de rodar `make up`

`make build`  
`make up`
`make test`


## Acessos via navegador

Listar clientes:  
http://localhost/clientes

Listar contas do cliente 101:  
http://localhost/contas/101

Exibir informações da conta 5001:  
http://localhost/conta/5001


## Ações via bash + wget

### Visualizações com respostas em json
wget -qc -O - http://localhost/clientes.json  
wget -qc -O - http://localhost/contas.json/101  
wget -qc -O - http://localhost/conta.json/5001  


### Operações:

#### Depositar na conta 5001:
wget -qc -O - http://localhost/api/depositar --method=POST --body-data="conta=5001&valor=15000"

#### Sacar da conta 5001:
wget -qc -O - http://localhost/api/sacar --method=POST --body-data="conta=5001&valor=1500.50"

#### Criar cliente:
wget -qc -O - http://localhost/api/cliente --method=PUT --body-data="nome=Fulano de Tal"

#### Criar conta para cliente 105:
wget -qc -O - http://localhost/api/conta --method=PUT --body-data="cliente=105"


