<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\QuotationResponseMail;

class UserController extends Controller
{
    // Show the list of quotations for the logged-in user
    public function showQuotations()
    {
        // Get all quotations associated with the logged-in user
        $quotations = Quotation::whereHas('prescription', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('user.quotations', compact('quotations'));
    }

    // Show a specific quotation for the user
    public function showQuotation($quotationId)
    {
        // Get the specific quotation for the logged-in user
        $quotation = Quotation::with('prescription')->whereHas('prescription', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($quotationId);

        return view('user.show-quotation', compact('quotation'));
    }

    // Handle the user accepting or rejecting the quotation
    public function respondToQuotation(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        // Update the quotation status
        $quotation->update(['status' => $validated['status']]);

        // Send an email notification to the pharmacy about the user's response
        $pharmacyEmail = 'pharmacy@example.com'; // Replace with dynamic pharmacy email if needed
        Mail::to($pharmacyEmail)->send(new QuotationResponseMail($quotation));

        return redirect()->route('user.quotations')->with('success', 'Your response to the quotation has been sent.');
    }
}
