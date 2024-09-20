@foreach($prescriptions as $prescription)
<div>
    <p>Prescription by: {{ $prescription->user->name }}</p>
    <p>Delivery Address: {{ $prescription->delivery_address }}</p>
    <p>Time Slot: {{ $prescription->delivery_time }}</p>
    <a href="{{ route('pharmacy.quotation.create', $prescription->id) }}">Create Quotation</a>
</div>
@endforeach