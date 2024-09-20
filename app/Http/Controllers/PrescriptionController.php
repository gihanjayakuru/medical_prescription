<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function create()
    {
        return view('prescriptions.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'delivery_address' => 'required|string',
            'delivery_time' => 'required|string',
            'note' => 'nullable|string',
            'prescription_images' => 'required|array|max:5',
            'prescription_images.*' => 'image|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('prescription_images')) {
            foreach ($request->file('prescription_images') as $image) {
                $imageName = time() . '.' . $image->extension();
                $image->storeAs('prescriptions', $imageName, 'public');
                $images[] = $imageName;
            }
        }

        Prescription::create([
            'user_id' => auth()->id(),
            'delivery_address' => $validatedData['delivery_address'],
            'delivery_time' => $validatedData['delivery_time'],
            'note' => $validatedData['note'],
            'prescription_images' => json_encode($images),
        ]);

        return redirect()->route('home');
    }
}
