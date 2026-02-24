<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Transaction Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:20px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" style="background:#ffffff; padding:20px; border-radius:6px;">
                    <tr>
                        <td>
                            <h2 style="color:#4f46e5; margin-bottom:10px;">
                                Transaction Confirmation
                            </h2>

                            <p>
                                Hello <strong>{{ $transaction->account->customer->name }}</strong>,
                            </p>

                            <p>
                                Your transaction has been successfully processed.
                                Below are the details:
                            </p>

                            <table width="100%" style="border-collapse: collapse; margin-top:15px;">
                                <tr>
                                    <td><strong>Transaction No:</strong></td>
                                    <td>{{ $transaction->transaction_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Type:</strong></td>
                                    <td>{{ ucfirst($transaction->type) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Amount:</strong></td>
                                    <td>₱{{ number_format($transaction->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date:</strong></td>
                                    <td>{{ $transaction->transaction_date }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Balance After:</strong></td>
                                    <td>₱{{ number_format($transaction->balance_after, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Method:</strong></td>
                                    <td>{{ $transaction->payment_method ?? 'N/A' }}</td>
                                </tr>
                            </table>

                            <p style="margin-top:20px;">
                                If you have any questions or did not authorize this transaction,
                                please contact us immediately.
                            </p>

                            <p style="margin-top:30px;">
                                Regards,<br>
                                <strong>LendingHub Team</strong>
                            </p>
                        </td>
                    </tr>
                </table>

                <p style="font-size:12px; color:#888; margin-top:10px;">
                    This is an automated email. Please do not reply.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
