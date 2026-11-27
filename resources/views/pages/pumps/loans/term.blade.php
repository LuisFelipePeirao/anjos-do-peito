<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Termo de empréstimo {{ $term['number'] }}</title>
    <style>
        @page { margin: 36px 42px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; line-height: 1.5; color: #202630; }
        h1 { font-size: 20px; margin: 8px 0; }
        h2 { font-size: 12px; margin: 20px 0 8px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        p { margin: 5px 0; overflow-wrap: anywhere; }
        .muted { color: #505763; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { text-align: left; padding: 6px; border-bottom: 1px solid #ddd; overflow-wrap: anywhere; }
        th { background: #f5f5f5; }
        tr { page-break-inside: avoid; }
        .notes { white-space: pre-wrap; }
        .signatures { page-break-inside: avoid; margin-top: 30px; }
        .signature { border-top: 1px solid #333; padding-top: 6px; margin-top: 45px; }
    </style>
</head>
<body>
    <p><strong>VITA · Anjos do Peito</strong></p>
    <h1>Termo de {{ mb_strtolower($term['type']) }}</h1>
    <p class="muted">Registro nº {{ $term['number'] }} · Emitido no cadastro em {{ $term['issued_at'] }}</p>

    <h2>Beneficiária</h2>
    <p><strong>Nome:</strong> {{ $term['beneficiary']['name'] }}</p>
    <p><strong>CPF:</strong> {{ $term['beneficiary']['cpf'] }} · <strong>Telefone:</strong> {{ $term['beneficiary']['phone'] ?: '-' }}</p>

    <h2>Equipamento e período</h2>
    <p><strong>Bomba:</strong> {{ $term['pump']['code'] }} · {{ $term['pump']['model'] }}</p>
    <p><strong>Número de série:</strong> {{ $term['pump']['serial'] ?: '-' }}</p>
    <p><strong>Acessórios:</strong> {{ $term['pump']['accessories'] ?: '-' }}</p>
    <p><strong>Retirada:</strong> {{ $term['withdrawn_at'] }} · <strong>Devolução prevista:</strong> {{ $term['expected_return'] }}</p>
    <p><strong>Responsável pela entrega:</strong> {{ $term['responsible'] }}</p>

    <h2>Condições de pagamento</h2>
    <p><strong>Mensalidade:</strong> {{ $term['monthly_fee'] }}</p>
    @if ($term['first_billing_at'])
        <p><strong>Forma de cobrança:</strong> {{ $term['billing_method'] }} · <strong>Dia de vencimento:</strong> {{ $term['due_day'] }}</p>
        <p><strong>Primeira cobrança:</strong> {{ $term['first_billing_at'] }}</p>
    @endif

    @if (count($term['payments']))
        <h2>Pagamentos registrados no cadastro</h2>
        <table>
            <thead><tr><th>Referência</th><th>Valor</th><th>Vencimento</th><th>Pagamento</th><th>Situação</th></tr></thead>
            <tbody>
                @foreach ($term['payments'] as $payment)
                    <tr><td>{{ $payment['reference'] }}</td><td>{{ $payment['amount'] }}</td><td>{{ $payment['due_at'] }}</td><td>{{ $payment['paid_at'] }}</td><td>{{ $payment['status'] }}</td></tr>
                @endforeach
            </tbody>
        </table>
        @foreach ($term['payments'] as $payment)
            @if ($payment['notes'])<p class="notes">{{ $payment['notes'] }}</p>@endif
        @endforeach
    @else
        <p>Empréstimo gratuito, sem pagamentos previstos.</p>
    @endif

    @if ($term['notes'])
        <h2>Observações da entrega</h2>
        <p class="notes">{{ $term['notes'] }}</p>
    @endif

    <div class="signatures">
        <p>Declaro o recebimento do equipamento e dos acessórios descritos neste termo, conforme o período e as condições acima.</p>
        <p>Local e data: _____________________________________________________</p>
        <p class="signature">Assinatura da beneficiária — {{ $term['beneficiary']['name'] }}</p>
        <p class="signature">Assinatura do responsável pela entrega — {{ $term['responsible'] }}</p>
    </div>
</body>
</html>
