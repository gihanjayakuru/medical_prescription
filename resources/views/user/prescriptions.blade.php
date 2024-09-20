@extends('layouts.layout')

@section('title', 'My Prescriptions')

@section('content')

<div class="container">
    <h1>My Prescriptions</h1>

    <!-- Display the 'Upload Prescription' button only if the user is logged in -->
    <div class="mb-3">
        <a href="{{ route('user.uploadPrescription') }}" class="btn btn-primary">
            Upload Prescription
        </a>
    </div>

    <!-- Display list of prescriptions -->
    @if($prescriptions->isEmpty())
    <p>No prescriptions found.</p>
    @else
    @foreach($prescriptions as $prescription)
    <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px;">
        <h2>Prescription by {{ $prescription->user->name }}</h2>
        <p><strong>Note:</strong> {{ $prescription->note }}</p>
        <p><strong>Delivery Address:</strong> {{ $prescription->delivery_address }}</p>
        <p><strong>Delivery Time:</strong> {{ $prescription->delivery_time }}</p>
        <h3>Prescription Images</h3>
        @if($prescription->images)
        @foreach(json_decode($prescription->images) as $image)
        <img src="{{ asset('storage/prescriptions/' . $image) }}" alt="Prescription Image" width="200px"
            style="margin-right: 10px;">
        @endforeach
        @else
        <p>No images uploaded.</p>
        @endif
        <br><br>
    </div>
    @endforeach
    @endif
</div>

@endsection