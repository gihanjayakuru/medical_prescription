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
        $quotations = Quotation::where('user_id', Auth::id())->get();

        return view('user.quotations', compact('quotations'));
    }


    // Method to respond to a quotation
    public function respondToQuotation(Request $request, $quotationId)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        // Find the quotation and update its status
        $quotation = Quotation::findOrFail($quotationId);
        $quotation->status = $request->status; // Update status
        $quotation->save();

        // Optionally, add logic to notify the pharmacy or log the response

        return redirect()->route('user.quotations')->with('success', 'Quotation response recorded successfully.');
    }
}
