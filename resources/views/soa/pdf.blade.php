<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Statement of Account</title>

<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        background: #f9fafb;
        padding: 20px;
    }

    .card {
        background: #ffffff;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .title {
        font-size: 20px;
        font-weight: bold;
        color: #4f46e5;
    }

    .subtitle {
        font-size: 13px;
        color: #6b7280;
    }

    .section-title {
        margin-top: 20px;
        font-weight: bold;
        font-size: 14px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th {
        background: #f3f4f6;
        padding: 8px;
        text-align: left;
        font-weight: bold;
        border: 1px solid #e5e7eb;
    }

    td {
        padding: 8px;
        border: 1px solid #e5e7eb;
    }

    .text-right {
        text-align: right;
    }

    .summary {
        margin-top: 15px;
        width: 50%;
        float: right;
    }

    .summary td {
        border: none;
        padding: 4px 0;
    }

    .total {
        font-weight: bold;
        font-size: 14px;
    }

    .footer {
        margin-top: 40px;
        text-align: center;
        font-size: 10px;
        color: #9ca3af;
    }
</style>
</head>

<body>

<div class="card">

    <div class="header">
        <div class="title">LendingHub</div>
        <div class="subtitle">Statement of Account</div>
        <div class="subtitle">Generated on {{ \Carbon\Carbon::now()->format('F d, Y') }}</div>
    </div>

    <div class="section-title">Account Information</div>
    <table>
        <tr>
            <td><strong>Customer Name</strong></td>
            <td>{{ $account->customer->name }}</td>
        </tr>
        <tr>
            <td><strong>Account Number</strong></td>
            <td>{{ $account->account_number }}</td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td>{{ ucfirst($account->status) }}</td>
        </tr>
        <tr>
            <td><strong>Principal Amount</strong></td>
            <td>₱{{ number_format($account->principal_amount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Current Balance</strong></td>
            <td>₱{{ number_format($account->balance, 2) }}</td>
        </tr>
    </table>

    <div class="section-title">Transaction History</div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Transaction #</th>
                <th>Type</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Balance After</th>
            </tr>
        </thead>
        <tbody>
            @foreach($account->transactions as $transaction)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}</td>
                    <td>{{ $transaction->transaction_number }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td class="text-right">₱{{ number_format($transaction->amount, 2) }}</td>
                    <td class="text-right">₱{{ number_format($transaction->balance_after, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td><strong>Total Balance:</strong></td>
            <td class="text-right total">
                ₱{{ number_format($account->balance, 2) }}
            </td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <div class="footer">
        This is a system-generated statement. Please contact us if you have any questions.
    </div>

</div>

</body>
</html>
