@extends('layouts.layout')

@section('title', 'My Quotations')

@section('content')

<div class="container">
    <h1>My Quotations</h1>

    @if($quotations->isEmpty())
    <p>No quotations available.</p>
    @else
    @foreach($quotations as $quotation)
    <div class="quotation-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 20px;">
        <h2>Quotation for Prescription #{{ $quotation->id }}</h2>
        <p><strong>Items:</strong></p>
        <ul>
            @foreach(json_decode($quotation->items, true) as $item)
            <li>{{ $item['drug'] }} - Quantity: {{ $item['quantity'] }} - Price: ${{ number_format($item['price'], 2) }}
            </li>
            @endforeach
        </ul>
        <p><strong>Total:</strong> ${{ number_format($quotation->total, 2) }}</p>
        <form action="{{ route('user.respondToQuotation', $quotation->id) }}" method="POST">
            @csrf
            <button type="submit" name="status" value="accepted" class="btn btn-success">Accept</button>
            <button type="submit" name="status" value="rejected" class="btn btn-danger">Reject</button>
        </form>
    </div>
    @endforeach
    @endif
</div>

@endsection