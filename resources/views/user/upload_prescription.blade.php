<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Prescription</title>
</head>

<body>
    <h1>Upload Your Prescription</h1>

    <form action="{{ route('user.uploadPrescription') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="note">Note:</label>
            <textarea name="note" required></textarea>
        </div>

        <div>
            <label for="delivery_address">Delivery Address:</label>
            <input type="text" name="delivery_address" required>
        </div>

        <div>
            <label for="delivery_time">Delivery Time:</label>
            <input type="text" name="delivery_time" placeholder="e.g., 10:00 AM - 12:00 PM" required>
        </div>

        <div>
            <label for="images">Upload Prescription Images (Max 5):</label>
            <input type="file" name="images[]" multiple required>
        </div>

        <button type="submit">Upload</button>
    </form>
</body>

</html>