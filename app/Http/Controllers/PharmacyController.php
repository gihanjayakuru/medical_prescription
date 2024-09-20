<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Quotation;
use App\Mail\QuotationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PharmacyController extends Controller
{

    public function index()
    {

        $prescriptions = Prescription::with('user')->get();
        return view('pharmacy.index', compact('prescriptions'));
    }

    public function createQuotation($prescriptionId)
    {
        $prescription = Prescription::findOrFail($prescriptionId);
        return view('pharmacy.create_quotation', compact('prescription'));
    }

    public function storeQuotation(Request $request, $prescriptionId)
    {
        $validatedData = $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $quotation = Quotation::create([
            'prescription_id' => $prescriptionId,
            'pharmacy_user_id' => Auth::id(),
            'items' => json_encode($validatedData['items']),
            'total' => $validatedData['total'],
            'status' => 'pending',
        ]);

        $prescription = Prescription::find($prescriptionId);
        Mail::to($prescription->user->email)->send(new QuotationMail($quotation));

        return redirect()->route('pharmacy.index')->with('success', 'Quotation created and sent to the user.');
    }

    public function storePrescription(Request $request)
    {
        $validatedData = $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable|string',
            'delivery_address' => 'required|string|max:255',
            'delivery_time' => 'required|string',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('prescriptions', 'public');
                $imagePaths[] = $path;
            }
        }

        Prescription::create([
            'user_id' => Auth::id(),
            'images' => json_encode($imagePaths),
            'note' => $validatedData['note'] ?? null,
            'delivery_address' => $validatedData['delivery_address'],
            'delivery_time' => $validatedData['delivery_time'],
        ]);

        return redirect()->route('user.prescriptions')->with('success', 'Prescription uploaded successfully!');
    }
}
