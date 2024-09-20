@extends('layouts.layout')

@section('title', 'Quotation Details')

@section('content')

<h1>Quotation Details</h1>

<div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 20px;">
    <h2>Prescription by {{ $quotation->prescription->user->name }}</h2>
    <p><strong>Note:</strong> {{ $quotation->prescription->note }}</p>
    <p><strong>Delivery Address:</strong> {{ $quotation->prescription->delivery_address }}</p>
    <p><strong>Delivery Time:</strong> {{ $quotation->prescription->delivery_time }}</p>
    <h3>Prescription Images</h3>

    @if($quotation->prescription->images)
    @foreach(json_decode($quotation->prescription->images) as $image)
    <img src="{{ asset('storage/' . $image) }}" alt="Prescription Image" width="200px"
        style="margin-right: 10px;">
    @endforeach
    @else
    <p>No images uploaded.</p>
    @endif
</div>

<div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 20px;">
    <h2>Quotation Items</h2>

    @if($quotation->items)
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid #ddd;">
                <th style="padding: 10px; text-align: left;">Item</th>
                <th style="padding: 10px; text-align: left;">Quantity</th>
                <th style="padding: 10px; text-align: left;">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach(json_decode($quotation->items) as $item)
            <tr>
                <td style="padding: 10px;">{{ $item->drug }}</td>
                <td style="padding: 10px;">{{ $item->quantity }}</td>
                <td style="padding: 10px;">${{ number_format($item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No items in this quotation.</p>
    @endif

    <h3>Total: ${{ number_format($quotation->total, 2) }}</h3>
</div>

<div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 20px;">
    <h2>Quotation Status</h2>
    <p><strong>Status:</strong> {{ ucfirst($quotation->status) }}</p>
</div>

@endsection