<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuotationResponseMail;


class UserController extends Controller
{
    public function respondToQuotation(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $quotation->update(['status' => $validated['status']]);

        // Notify the pharmacy
        $pharmacyEmail = 'pharmacy@example.com';
        Mail::to($pharmacyEmail)->send(new QuotationResponseMail($quotation));

        return redirect()->route('user.quotations');
    }
}
