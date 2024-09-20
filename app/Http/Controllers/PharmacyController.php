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
    // Display all prescriptions for pharmacy users
    public function index()
    {
        // Get all prescriptions uploaded by users
        $prescriptions = Prescription::with('user')->get();
        return view('pharmacy.index', compact('prescriptions'));
    }

    // Display form for creating a quotation for a prescription
    public function createQuotation($prescriptionId)
    {
        $prescription = Prescription::findOrFail($prescriptionId);
        return view('pharmacy.create_quotation', compact('prescription'));
    }

    // Store the created quotation and send notification to the user
    public function storeQuotation(Request $request, $prescriptionId)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        // Create a new quotation
        $quotation = Quotation::create([
            'prescription_id' => $prescriptionId,
            'pharmacy_user_id' => Auth::id(),
            'items' => json_encode($validatedData['items']),
            'total' => $validatedData['total'],
            'status' => 'pending', // Initial status of quotation
        ]);

        // Send email notification to the user
        $prescription = Prescription::find($prescriptionId);
        Mail::to($prescription->user->email)->send(new QuotationMail($quotation));

        // Redirect back to the pharmacy dashboard with success message
        return redirect()->route('pharmacy.index')->with('success', 'Quotation created and sent to the user.');
    }

    // Store a new prescription
    public function storePrescription(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Max size 2MB
            'note' => 'nullable|string',
            'delivery_address' => 'required|string|max:255',
            'delivery_time' => 'required|string',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('prescriptions', 'public'); // Store in 'storage/app/public/prescriptions'
                $imagePaths[] = $path;
            }
        }

        // Create a new prescription
        Prescription::create([
            'user_id' => Auth::id(),
            'images' => json_encode($imagePaths),
            'note' => $validatedData['note'] ?? null,
            'delivery_address' => $validatedData['delivery_address'],
            'delivery_time' => $validatedData['delivery_time'],
        ]);

        // Redirect with success message
        return redirect()->route('user.prescriptions')->with('success', 'Prescription uploaded successfully!');
    }
}
