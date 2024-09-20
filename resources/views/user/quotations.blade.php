<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Quotations</title>
</head>

<body>
    <h1>Your Quotations</h1>

    @if($quotations->isEmpty())
    <p>No quotations available.</p>
    @else
    @foreach($quotations as $quotation)
    <div>
        <h2>Quotation for Prescription</h2>
        <p><strong>Items:</strong></p>
        <ul>
            @foreach(json_decode($quotation->items, true) as $item)
            <li>{{ $item['drug'] }} - Quantity: {{ $item['quantity'] }} - Price: {{ $item['price'] }}</li>
            @endforeach
        </ul>
        <p><strong>Total:</strong> ${{ $quotation->total }}</p>
        <form action="{{ route('user.respondToQuotation', $quotation->id) }}" method="POST">
            @csrf
            <button type="submit" name="status" value="accepted">Accept</button>
            <button type="submit" name="status" value="rejected">Reject</button>
        </form>
    </div>
    @endforeach
    @endif
</body>

</html>