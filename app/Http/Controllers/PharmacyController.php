<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Quotation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with('user')->get();
        return view('pharmacy.index', compact('prescriptions'));
    }

    public function createQuotation(Request $request, $prescriptionId)
    {
        $validatedData = $request->validate([
            'items' => 'required|array',
            'total' => 'required|numeric',
        ]);

        Quotation::create([
            'prescription_id' => $prescriptionId,
            'pharmacy_user_id' => auth()->id(),
            'items' => json_encode($validatedData['items']),
            'total' => $validatedData['total'],
        ]);

        // Send email to user
        $prescription = Prescription::find($prescriptionId);
        Mail::to($prescription->user->email)->send(new QuotationMail($prescription));

        return redirect()->route('pharmacy.index');
    }
}
