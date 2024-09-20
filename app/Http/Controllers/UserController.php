<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\QuotationResponseMail;

class UserController extends Controller
{
    public function showQuotations()
    {
        $quotations = Quotation::whereHas('prescription', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('user.quotations', compact('quotations'));
    }

    public function showQuotation($quotationId)
    {
        $quotation = Quotation::with('prescription')->whereHas('prescription', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($quotationId);

        return view('user.show-quotation', compact('quotation'));
    }

    public function respondToQuotation(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $quotation->update(['status' => $validated['status']]);

        $pharmacyEmail = 'pharmacy@example.com';
        Mail::to($pharmacyEmail)->send(new QuotationResponseMail($quotation));

        return redirect()->route('user.quotations')->with('success', 'Your response to the quotation has been sent.');
    }
}
