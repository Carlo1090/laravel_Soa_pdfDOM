<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monthly Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            padding: 20px;
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
            font-size: 14px;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #f3f4f6;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #e5e7eb;
        }

        td {
            padding: 10px;
            border: 1px solid #e5e7eb;
        }

        .text-right {
            text-align: right;
        }

        .total-section {
            margin-top: 20px;
            width: 50%;
            margin-left: auto;
        }

        .total-table {
            border: 1px solid #e5e7eb;
        }

        .total-table td {
            border: none;
            padding: 8px;
        }

        .total-row {
            font-weight: bold;
            font-size: 14px;
        }

        .disbursement-total {
            color: #dc2626;
        }

        .payment-total {
            color: #16a34a;
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

    <div class="header">
        <div class="title">LendingHub</div>
        <div class="subtitle">Monthly Transaction Report</div>
        <div class="subtitle">{{ $month }} {{ $year }}</div>
        <div class="subtitle">Generated on {{ \Carbon\Carbon::now()->format('F d, Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Account Number</th>
                <th class="text-right">Disbursement</th>
                <th class="text-right">Payment</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportData as $row)
                <tr>
                    <td>{{ $row['customer_name'] }}</td>
                    <td>{{ $row['account_number'] }}</td>
                    <td class="text-right">₱{{ number_format($row['disbursement'], 2) }}</td>
                    <td class="text-right">₱{{ number_format($row['payment'], 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No transactions found for this period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-section">
        <table class="total-table">
            <tr class="total-row disbursement-total">
                <td><strong>Total Disbursement:</strong></td>
                <td class="text-right">₱{{ number_format($totalDisbursement, 2) }}</td>
            </tr>
            <tr class="total-row payment-total">
                <td><strong>Total Payment:</strong></td>
                <td class="text-right">₱{{ number_format($totalPayment, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        This is a system-generated report. Please contact us if you have any questions.
    </div>

</body>
</html>
