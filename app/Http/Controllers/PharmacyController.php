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
        $prescriptions = Prescription::with('user')->get();
        return view('pharmacy.index', compact('prescriptions'));
    }

    // Show the form for creating a quotation for a prescription
    public function createQuotation($prescriptionId)
    {
        $prescription = Prescription::findOrFail($prescriptionId);
        return view('pharmacy.create_quotation', compact('prescription'));
    }

    public function showQuotations()
    {
        // Fetch quotations created by the authenticated pharmacy user
        $quotations = Quotation::where('pharmacy_user_id', Auth::id())->get();

        return view('pharmacy.quotations', compact('quotations'));
    }

    public function storeQuotation(Request $request, $prescriptionId)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'items' => 'required|string', // Expecting a JSON string
            'total' => 'required|numeric|min:0',
        ]);

        // Decode the JSON string to an array
        $quotationItems = json_decode($validatedData['items'], true);

        // Additional validation for the decoded items
        foreach ($quotationItems as $item) {
            if (!isset($item['drug'], $item['quantity'], $item['price'])) {
                return redirect()->back()->withErrors(['msg' => 'Invalid item data.']);
            }
        }

        // Create a new quotation
        $quotation = Quotation::create([
            'prescription_id' => $prescriptionId,
            'pharmacy_user_id' => Auth::id(), // ID of the logged-in pharmacy user
            'user_id' => Prescription::find(id: $prescriptionId)->user_id, // Set the user ID from the prescription
            'items' => json_encode($quotationItems), // Store items as JSON
            'total' => $validatedData['total'], // Total amount
            'status' => 'pending', // Initial status of the quotation
        ]);

        // Send email notification to the user
        $prescription = Prescription::findOrFail($prescriptionId);
        Mail::to($prescription->user->email)->send(new QuotationMail($quotation));

        // Redirect back to the pharmacy dashboard with success message
        return redirect()->route('pharmacy.index')->with('success', 'Quotation created and sent to the user.');
    }



    // Store a new prescription
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
                $path = $image->store('uploads/prescriptions', 'public');
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
