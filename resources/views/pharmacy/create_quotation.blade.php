<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quotation</title>
</head>

<body>
    <h1>Create Quotation for Prescription</h1>

    <form action="{{ route('pharmacy.storeQuotation', $prescription->id) }}" method="POST">
        @csrf

        <div>
            <label for="drug">Drug:</label>
            <input type="text" name="items[0][drug]" required>
        </div>

        <div>
            <label for="quantity">Quantity:</label>
            <input type="number" name="items[0][quantity]" required>
        </div>

        <div>
            <label for="price">Price per unit:</label>
            <input type="number" step="0.01" name="items[0][price]" required>
        </div>

        <div>
            <button type="button" id="addMore">Add More Items</button>
        </div>

        <div>
            <label for="total">Total Price:</label>
            <input type="number" step="0.01" name="total" required>
        </div>

        <div>
            <button type="submit">Send Quotation</button>
        </div>
    </form>

    <script>
        document.getElementById('addMore').addEventListener('click', function() {
            // Add logic to dynamically add more item input fields
        });
    </script>
</body>

</html>