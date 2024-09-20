<form action="{{ route('prescriptions.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="delivery_address">Delivery Address</label>
    <input type="text" name="delivery_address" required>

    <label for="delivery_time">Delivery Time</label>
    <input type="text" name="delivery_time" required>

    <label for="note">Note</label>
    <textarea name="note"></textarea>

    <label for="prescription_images">Prescription Images (Max 5)</label>
    <input type="file" name="prescription_images[]" multiple required>

    <button type="submit">Submit</button>
</form>