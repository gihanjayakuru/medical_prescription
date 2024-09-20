@extends('layouts.email')

@section('content')
<h1>Your Quotation for Prescription #{{ $quotation->prescription_id }}</h1>

<p>Here are the details of your quotation:</p>
<ul>
    @foreach(json_decode($quotation->items, true) as $item)
    <li>{{ $item['drug'] }} - Quantity: {{ $item['quantity'] }} - Price: ${{ number_format($item['price'], 2) }} -
        Total: ${{ number_format($item['amount'], 2) }}</li>
    @endforeach
</ul>

<p><strong>Total Amount:</strong> ${{ number_format($quotation->total, 2) }}</p>
@endsection