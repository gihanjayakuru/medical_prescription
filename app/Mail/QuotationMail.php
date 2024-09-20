<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Mail\Mailable;


class QuotationMail extends Mailable
{
    public $quotation;

    public function __construct(Quotation $quotation)
    {
        $this->quotation = $quotation;
    }

    public function build()
    {
        return $this->view('emails.quotation')->with([
            'quotation' => $this->quotation,
        ]);
    }
}
