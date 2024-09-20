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
        $prescription = Prescription::with('user')->findOrFail($prescriptionId);
        return view('pharmacy.create_quotation', compact('prescription'));
    }

    public function store(Request $request, $prescriptionId)
    {
        $validatedData = $request->validate([
            'items' => 'required|json',
            'total' => 'required|numeric',
        ]);

        $quotation = Quotation::create([
            'prescription_id' => $prescriptionId,
            'pharmacy_user_id' => auth()->id(),
            'items' => $validatedData['items'],
            'total' => $validatedData['total'],
        ]);
        $prescription = Prescription::findOrFail($prescriptionId);
        $prescription->quotation_id = $quotation->id;
        $prescription->save();

        Mail::to($prescription->user->email)->send(new QuotationMail($quotation));

        return redirect()->route('pharmacy.index')->with('success', 'Quotation created and sent to the user.');
    }

    public function show($quotationId)
    {
        $quotation = Quotation::with('prescription.user')->findOrFail($quotationId);

        return view('pharmacy.show-quotation', compact('quotation'));
    }
}