@extends('layouts.layout')

@section('title', 'Uploaded Prescriptions')

@section('content')

<div class="container">
    <h1>Uploaded Prescriptions</h1>

    @if($prescriptions->isEmpty())
    <p>No prescriptions available.</p>
    @else
    @foreach($prescriptions as $prescription)
    <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 20px;">
        <h2>Prescription by {{ $prescription->user->name }}</h2>
        <p><strong>Note:</strong> {{ $prescription->note }}</p>
        <p><strong>Delivery Address:</strong> {{ $prescription->delivery_address }}</p>
        <p><strong>Delivery Time:</strong> {{ $prescription->delivery_time }}</p>

        <h3>Prescription Images</h3>
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/' . json_decode($prescription->images)[0]) }}"
                    alt="Prescription Image" class="img-fluid" style="border: 1px solid #ccc; margin-bottom: 10px;">
            </div>
        </div>

        <div class="row">
            @foreach(array_slice(json_decode($prescription->images), 1) as $image)
            <div class="col-md-2">
                <img src="{{ asset('storage/' . $image) }}" alt="Prescription Thumbnail" class="img-fluid"
                    style="border: 1px solid #ccc; margin-bottom: 10px;">
            </div>
            @endforeach
        </div>
        <a href="{{ route('pharmacy.createQuotation', $prescription->id) }}" class="btn btn-primary">Create
            Quotation</a>
    </div>
    @endforeach
    @endif
</div>

@endsection
