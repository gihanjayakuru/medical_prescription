@extends('layouts.layout')

@section('title', 'Create Quotation')

@section('content')

<div class="container">
    <div class="image-gallery">
        <h3>Prescription (Image)</h3>
        <img src="{{ asset('storage/' . json_decode($prescription->images)[0]) }}"
            alt="Prescription Image" class="img-fluid">
        <div class="row mt-2">
            @foreach(array_slice(json_decode($prescription->images), 1) as $image)
            <div class="col-md-12">
                <img src="{{ asset('storage/' . $image) }}" alt="Thumbnail" class="img-fluid">
            </div>
            @endforeach
        </div>
    </div>

    <div class="quotation-form">
        <h3>Quotation</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Drug</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="quotation-items">
            </tbody>
        </table>

        <h4>Total: <span id="total">0.00</span></h4>

        <form id="add-quotation-item-form">
            @csrf
            <div class="form-group">
                <label for="drug">Drug</label>
                <input type="text" name="drug" id="drug" class="form-control" placeholder="Enter drug name" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity"
                    required>
            </div>
            <div class="form-group">
                <label for="price">Unit Price</label>
                <input type="number" name="price" id="price" class="form-control" placeholder="Enter unit price"
                    required>
            </div>
            <button type="button" class="btn btn-primary" id="add-item">Add</button>
        </form>

        <form action="{{ route('pharmacy.storeQuotation', $prescription->id) }}" method="POST">
            @csrf
            <input type="hidden" name="items" id="items">
            <input type="hidden" name="total" id="total-input">
            <button type="submit" class="btn btn-success mt-3">Send Quotation</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('add-item').addEventListener('click', function () {
        let drug = document.getElementById('drug').value;
        let quantity = parseInt(document.getElementById('quantity').value);
        let price = parseFloat(document.getElementById('price').value);
        let amount = quantity * price;

        // Format the row to include the unit price and total
        let row = `<tr>
            <td>${drug}</td>
            <td>${quantity} x ${price.toFixed(2)}</td>
            <td>${price.toFixed(2)}</td>
            <td>${amount.toFixed(2)}</td>
        </tr>`;

        document.getElementById('quotation-items').insertAdjacentHTML('beforeend', row);

        let totalElement = document.getElementById('total');
        let currentTotal = parseFloat(totalElement.textContent);
        currentTotal += amount;
        totalElement.textContent = currentTotal.toFixed(2);

        // Clear input fields
        document.getElementById('drug').value = '';
        document.getElementById('quantity').value = '';
        document.getElementById('price').value = '';

        updateHiddenFields();
    });

    function updateHiddenFields() {
        let items = [];
        document.querySelectorAll('#quotation-items tr').forEach(function (row) {
            let cells = row.querySelectorAll('td');
            items.push({
                drug: cells[0].textContent,
                quantity: parseInt(cells[1].textContent.split(' x ')[0]),
                price: parseFloat(cells[2].textContent),
                amount: parseFloat(cells[3].textContent)
            });
        });

        document.getElementById('items').value = JSON.stringify(items);
        document.getElementById('total-input').value = document.getElementById('total').textContent;
    }
</script>

@endsection