<?php

namespace App\Observers;

use App\Mail\TransactionOfAccount;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        $transaction->load('account.customer');

        // Generate PDF receipt
        $pdf = $this->generatePdf($transaction);

        // Save PDF to storage
        $fileName = 'transaction_receipt_' . $transaction->transaction_number . '.pdf';
        
        // Ensure receipts directory exists
        if (!Storage::disk('local')->exists('receipts')) {
            Storage::disk('local')->makeDirectory('receipts');
        }
        
        Storage::disk('local')->put('receipts/' . $fileName, $pdf->output());

        // Send email notification
        $this->sendEmailNotification($transaction);
    }

    /**
     * Generate PDF receipt for the transaction.
     */
    protected function generatePdf(Transaction $transaction)
    {
        return Pdf::loadView('emails.transaction-pdf', [
            'transaction' => $transaction,
            'customer' => $transaction->account->customer,
            'account' => $transaction->account,
        ]);
    }

    /**
     * Send email notification to customer.
     */
    protected function sendEmailNotification(Transaction $transaction): void
    {
        Mail::to($transaction->account->customer->email)
            ->queue(new TransactionOfAccount($transaction));
    }
}

