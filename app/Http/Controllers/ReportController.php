<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Show report form
    public function index()
    {
        return view('reports.index');
    }

    // Generate PDF report
    public function generatePdf(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        $month = $validated['month'];
        $year = $validated['year'];

        // Get transactions for selected month/year
        $transactions = Transaction::with('account.customer')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->orderBy('transaction_date')
            ->get();

        // Group by account
        $groupedData = $transactions->groupBy('account_id');

        // Prepare data
        $reportData = [];
        $totalDisbursement = 0;
        $totalPayment = 0;

        foreach ($groupedData as $accountId => $accountTransactions) {
            $account = $accountTransactions->first()->account;
            $customer = $account->customer;

            $disbursement = $accountTransactions->where('type', 'disbursement')->sum('amount');
            $payment = $accountTransactions->where('type', 'payment')->sum('amount');

            $reportData[] = [
                'customer_name' => $customer->name,
                'account_number' => $account->account_number,
                'disbursement' => $disbursement,
                'payment' => $payment,
            ];

            $totalDisbursement += $disbursement;
            $totalPayment += $payment;
        }

        // Generate PDF
        $pdf = Pdf::loadView('reports.pdf', [
            'reportData' => $reportData,
            'totalDisbursement' => $totalDisbursement,
            'totalPayment' => $totalPayment,
            'month' => Carbon::createFromDate($year, $month)->format('F'),
            'year' => $year,
        ]);

        return $pdf->stream("Report_{$month}_{$year}.pdf");
    }
}
