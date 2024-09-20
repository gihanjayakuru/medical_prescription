<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescriptions</title>
</head>

<body>
    <h1>Uploaded Prescriptions</h1>

    @if($prescriptions->isEmpty())
    <p>No prescriptions available.</p>
    @else
    @foreach($prescriptions as $prescription)
    <div>
        <h2>Prescription by {{ $prescription->user->name }}</h2>
        <p><strong>Note:</strong> {{ $prescription->note }}</p>
        <p><strong>Delivery Address:</strong> {{ $prescription->delivery_address }}</p>
        <p><strong>Delivery Time:</strong> {{ $prescription->delivery_time }}</p>
        <h3>Prescription Images</h3>
        @foreach($prescription->images as $image)
        <img src="{{ asset('storage/prescriptions/' . $image) }}" alt="Prescription Image" width="200px">
        @endforeach
        <br>
        <a href="{{ route('pharmacy.createQuotation', $prescription->id) }}">Create Quotation</a>
    </div>
    @endforeach
    @endif
</body>

</html>