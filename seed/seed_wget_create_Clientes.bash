#! /bin/env bash
IFS=$'\n'
#set -x

nomes=
initial_id=
if [ $(wget -qc -O - http://localhost/clientes.json | wc -c) -lt 5 ]; then
    nomes="Fernando Abreu\nRicardo Alves\nBruno Lima\nAndre Brasiliano\nMichèle Roy-Coste\n"
    initial_id=101
else
    echo '# Coletando nomes... (aguarde cerca de 30 segundos)'
    for i in $(seq 1 3); do
        nome=$(wget -q -O - https://api.namefake.com/french-france/random/ | sed 's/.*name":"\(.*\)","address.*/\1/')
        nomes+="$nome\n"
    done
fi

for nome in $(echo -e $nomes); do
    [ ${#nome} -lt 3 ] && continue

    echo -e "\n### Criando cliente: $nome..."

    data="nome=$nome"
    [ -n "$initial_id" ] && data+="&id=$initial_id"

    res=$(wget -qc -O - http://localhost/api/cliente --method=PUT --body-data="$data")
    cliente=$(echo $res | sed 's/.*"id":\([0-9]\+\),.*/\1/')
    echo "    Resultado: $res"

    [ -n "$initial_id" ] && bash seed_wget_create_Conta.bash $cliente $(($initial_id+4900)) && initial_id=
done

