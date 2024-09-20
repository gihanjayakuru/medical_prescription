<!DOCTYPE html>
<html>

<head>
    <title>Quotation Details</title>
</head>

<body>
    <h1>Quotation for Prescription #{{ $quotation->prescription_id }}</h1>
    <p><strong>Total:</strong> ${{ number_format($quotation->total, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($quotation->status) }}</p>

    <h3>Items:</h3>
    <ul>
        @foreach(json_decode($quotation->items, true) as $item)
        <li>{{ $item['drug'] }} - Quantity: {{ $item['quantity'] }} - Price: ${{ number_format($item['price'], 2) }}
        </li>
        @endforeach
    </ul>
</body>

</html>