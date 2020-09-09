#! /bin/env bash
IFS=$'\n'
#set -x

[ -n "$1" ] && [ $1 -gt 0 ] && cliente=$1
[ -n "$2" ] && [ $2 -gt 0 ] && conta=$2

if [ -n "$cliente" ] && [ $(wget -qc -O - http://localhost/clientes.json | grep \"id\":$cliente, | wc -l) -gt 0 ]; then
    data="cliente=$cliente"
    [ -n "$conta" ] && [ $conta -gt 0 ] && data+="&id=$conta"

    echo -e "\n### Criando conta para cliente $cliente..."
    res=$(wget -qc -O - http://localhost/api/conta --method=PUT --body-data="$data")
    echo "    Resultado: $res"
fi

