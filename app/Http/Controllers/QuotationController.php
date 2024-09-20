<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuotationMail;

class QuotationController extends Controller
{
    public function create($prescriptionId)
    {
        // Get the prescription data to display, including related user data
        $prescription = Prescription::with('user')->findOrFail($prescriptionId);
        return view('pharmacy.create_quotation', compact('prescription'));
    }

    public function store(Request $request, $prescriptionId)
    {
        $validatedData = $request->validate([
            'items' => 'required|json',
            'total' => 'required|numeric',
        ]);

        // Create the quotation
        $quotation = Quotation::create([
            'prescription_id' => $prescriptionId,
            'pharmacy_user_id' => auth()->id(),
            'items' => $validatedData['items'],
            'total' => $validatedData['total'],
        ]);

        // Link the quotation with the prescription
        $prescription = Prescription::findOrFail($prescriptionId);
        $prescription->quotation_id = $quotation->id;
        $prescription->save();

        // Send the quotation to the user via email (optional)
        Mail::to($prescription->user->email)->send(new QuotationMail($quotation));

        return redirect()->route('pharmacy.index')->with('success', 'Quotation created and sent to the user.');
    }

    // Show a specific quotation for the pharmacy user
    public function show($quotationId)
    {
        // Find the specific quotation and related prescription
        $quotation = Quotation::with('prescription.user')->findOrFail($quotationId);

        return view('pharmacy.show-quotation', compact('quotation'));
    }
}
