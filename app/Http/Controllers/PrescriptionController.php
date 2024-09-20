<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::where('user_id', Auth::id())->get();

        return view('user.prescriptions', compact('prescriptions'));
    }

    public function create()
    {
        return view('user.upload_prescription');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'images' => 'required|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'note' => 'nullable|string',
            'delivery_address' => 'required|string',
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
            'note' => $validatedData['note'],
            'delivery_address' => $validatedData['delivery_address'],
            'delivery_time' => $validatedData['delivery_time'],
        ]);

        // Redirect back to the user's prescription list
        return redirect()->route('user.prescriptions')->with('success', 'Prescription uploaded successfully.');
    }

    public function show($id)
    {
        $prescription = Prescription::where('user_id', Auth::id())->findOrFail($id);

        return view('user.show-prescription', compact('prescription'));
    }

    public function destroy($id)
    {
        $prescription = Prescription::where('user_id', Auth::id())->findOrFail($id);

        $images = json_decode($prescription->images);
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }

        $prescription->delete();

        return redirect()->route('user.prescriptions')->with('success', 'Prescription deleted successfully.');
    }
}