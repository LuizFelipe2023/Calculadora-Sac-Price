<?php

function calcularSac($valorEmprestimo, $taxaJuros, $n_parcelas)
{
    $parcelaAmortizacao = $valorEmprestimo / $n_parcelas;
    $saldoDevedor = $valorEmprestimo;
    $jurosTotal = 0;
    $prestacoes = [];
    for ($i = 1; $i <= $n_parcelas; $i++) {
        $juros = $saldoDevedor * ($taxaJuros / 100);
        $prestacao = $parcelaAmortizacao + $juros;
        $saldoDevedor -= $parcelaAmortizacao;
        $jurosTotal += $juros;


        $prestacoes[] = [
            'parcela' => $i,
            'juros' => $juros,
            'amortizacao' => $parcelaAmortizacao,
            'prestacao_total' => $prestacao,
            'saldo_devedor' => $saldoDevedor < 0 ? 0 : $saldoDevedor 
        ];
    }
    return [
        'prestacoes' => $prestacoes,
        'juros_total' => $jurosTotal
    ];
}
function calcularPrice($valorEmprestimo, $taxaJuros, $numParcelas) {
    $taxaJuros = $taxaJuros / 100;
    $parcela = $valorEmprestimo * ($taxaJuros / (1 - pow(1 + $taxaJuros, -$numParcelas)));
    $jurosTotal = 0;
    $prestacoes = [];

    for ($i = 1; $i <= $numParcelas; $i++) {
        $juros = $valorEmprestimo * $taxaJuros;
        $amortizacao = $parcela - $juros;
        $jurosTotal += $juros;
        $valorEmprestimo -= $amortizacao;

        $prestacoes[] = [
            'parcela' => $i,
            'juros' => $juros,
            'amortizacao' => $amortizacao,
            'prestacao_total' => $parcela,
            'saldo_devedor' => $valorEmprestimo < 0 ? 0 : $valorEmprestimo 
        ];
    }

    return [
        'prestacoes' => $prestacoes,
        'juros_total' => $jurosTotal
    ];
}


