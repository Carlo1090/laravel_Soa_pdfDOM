<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Transaction Receipt - {{ $transaction->transaction_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }

        .company-tagline {
            font-size: 12px;
            color: #6b7280;
        }

        .receipt-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            color: #111;
        }

        .receipt-number {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 20px;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-section h3 {
            font-size: 14px;
            color: #4f46e5;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 8px;
            border: none;
        }

        .info-table td:first-child {
            font-weight: bold;
            width: 40%;
            color: #6b7280;
        }

        .info-table td:last-child {
            color: #111;
        }

        .amount-section {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .amount-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .amount-label {
            font-weight: bold;
            color: #6b7280;
        }

        .amount-value {
            font-weight: bold;
            font-size: 16px;
        }

        .disbursement {
            color: #dc2626;
        }

        .payment {
            color: #16a34a;
        }

        .balance-section {
            border-top: 2px solid #4f46e5;
            padding-top: 20px;
            margin-top: 20px;
        }

        .balance-amount {
            font-size: 20px;
            font-weight: bold;
            color: #4f46e5;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-completed {
            background: #dcfce7;
            color: #16a34a;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="company-name">LendingHub</div>
        <div class="company-tagline">Your Trusted Lending Partner</div>
        <div class="receipt-title">Transaction Receipt</div>
        <div class="receipt-number">Receipt No: {{ $transaction->transaction_number }}</div>
        <span class="status-badge status-completed">Completed</span>
    </div>

    <div class="info-section">
        <h3>Customer Information</h3>
        <table class="info-table">
            <tr>
                <td>Customer Name:</td>
                <td>{{ $customer->name }}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <td>Account Number:</td>
                <td>{{ $account->account_number }}</td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <h3>Transaction Details</h3>
        <table class="info-table">
            <tr>
                <td>Transaction Type:</td>
                <td class="{{ $transaction->type === 'disbursement' ? 'disbursement' : 'payment' }}">
                    {{ ucfirst($transaction->type) }}
                </td>
            </tr>
            <tr>
                <td>Transaction Date:</td>
                <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('F d, Y') }}</td>
            </tr>
            <tr>
                <td>Payment Method:</td>
                <td>{{ $transaction->payment_method ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Reference Number:</td>
                <td>{{ $transaction->reference_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Processed By:</td>
                <td>{{ $transaction->processedBy->name ?? 'System' }}</td>
            </tr>
            @if($transaction->notes)
            <tr>
                <td>Notes:</td>
                <td>{{ $transaction->notes }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="amount-section">
        <div class="amount-row">
            <span class="amount-label">Transaction Amount:</span>
            <span class="amount-value {{ $transaction->type === 'disbursement' ? 'disbursement' : 'payment' }}">
                {{ $transaction->type === 'disbursement' ? '+' : '-' }}₱{{ number_format($transaction->amount, 2) }}
            </span>
        </div>
        
        <div class="amount-row balance-section">
            <span class="amount-label">Balance After Transaction:</span>
            <span class="amount-value balance-amount">
                ₱{{ number_format($transaction->balance_after, 2) }}
            </span>
        </div>
    </div>

    <div class="footer">
        <p>This is a computer-generated receipt. No signature is required.</p>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F d, Y g:i A') }}</p>
        <p>If you have any questions, please contact us at support@lendinghub.com</p>
    </div>

</body>
</html>

