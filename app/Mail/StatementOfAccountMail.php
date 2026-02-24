<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\Account;
use Barryvdh\DomPDF\Facade\Pdf;

class StatementOfAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Account $account)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Statement Of Account',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.soa',
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('soa.pdf', [
            'account' => $this->account->load('customer', 'transactions')
        ]);

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                'SOA_'.$this->account->account_number.'.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
