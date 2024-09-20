<?php

namespace App\Mail;

use App\Models\Quotation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quotation;

    /**
     * Create a new message instance.
     *
     * @param Quotation $quotation
     * @return void
     */
    public function __construct(Quotation $quotation)
    {
        $this->quotation = $quotation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.quotation_response')
            ->with([
                'quotation' => $this->quotation,
                'status' => $this->quotation->status,
                'user' => $this->quotation->prescription->user->name,
            ])
            ->subject('Quotation Response from ' . $this->quotation->prescription->user->name);
    }
}
