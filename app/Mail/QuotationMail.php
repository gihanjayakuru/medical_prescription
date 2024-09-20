<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class QuotationMail extends Mailable
{
    public $quotation;

    public function __construct($quotation)
    {
        $this->quotation = $quotation;
    }

    public function build()
    {
        return $this->view('emails.quotation')
            ->subject('New Quotation');
    }
}
