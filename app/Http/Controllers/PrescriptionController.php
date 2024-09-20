<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    // Display a list of prescriptions for the logged-in user
    public function index()
    {
        // Fetch prescriptions associated with the logged-in user
        $prescriptions = Prescription::where('user_id', Auth::id())->get();

        // Pass the prescriptions to the view
        return view('user.prescriptions', compact('prescriptions'));
    }

    // Show the form to upload a new prescription
    public function create()
    {
        return view('user.upload_prescription');
    }

    // Store the uploaded prescription
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'images' => 'required|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'note' => 'nullable|string',
            'delivery_address' => 'required|string',
            'delivery_time' => 'required|string',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('prescriptions', 'public');
                $imagePaths[] = $path;
            }
        }

        // Create the prescription entry
        Prescription::create([
            'user_id' => Auth::id(),
            'images' => json_encode($imagePaths),
            'note' => $validatedData['note'],
            'delivery_address' => $validatedData['delivery_address'],
            'delivery_time' => $validatedData['delivery_time'],
        ]);

        // Redirect back to the user's prescription list
        return redirect()->route('user.prescriptions')->with('success', 'Prescription uploaded successfully.');
    }

    // Show details of a specific prescription
    public function show($id)
    {
        // Find the prescription for the logged-in user
        $prescription = Prescription::where('user_id', Auth::id())->findOrFail($id);

        return view('user.show-prescription', compact('prescription'));
    }

    // Delete a prescription
    public function destroy($id)
    {
        // Find the prescription for the logged-in user
        $prescription = Prescription::where('user_id', Auth::id())->findOrFail($id);

        // Delete prescription images from storage
        $images = json_decode($prescription->images);
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }

        // Delete the prescription record
        $prescription->delete();

        return redirect()->route('user.prescriptions')->with('success', 'Prescription deleted successfully.');
    }
}
