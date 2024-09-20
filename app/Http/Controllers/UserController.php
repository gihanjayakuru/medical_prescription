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
        $validatedData = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        // Update the quotation status
        $quotation = Quotation::findOrFail($quotationId);
        $quotation->status = $validatedData['status'];
        $quotation->save();

        return redirect()->route('user.quotations')->with('success', 'Quotation status updated.');
    }
}
