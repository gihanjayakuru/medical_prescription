@extends('layouts.layout')

@section('title', 'Upload Prescription')

@section('content')

<div class="container">
    <h1>Upload Prescription</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('user.storePrescription') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="images">Upload Prescription Images (Max 5)</label>
            <input type="file" name="images[]" multiple class="form-control" accept="image/*" required>
        </div>

        <div class="form-group">
            <label for="note">Note (Optional)</label>
            <textarea name="note" class="form-control" placeholder="Add any additional information..."></textarea>
        </div>

        <div class="form-group">
            <label for="delivery_address">Delivery Address</label>
            <input type="text" name="delivery_address" class="form-control" placeholder="Enter delivery address"
                required>
        </div>

        <div class="form-group">
            <label for="delivery_time">Delivery Time</label>
            <select name="delivery_time" class="form-control" required>
                <option value="08:00 - 10:00">08:00 - 10:00</option>
                <option value="10:00 - 12:00">10:00 - 12:00</option>
                <option value="12:00 - 14:00">12:00 - 14:00</option>
                <option value="14:00 - 16:00">14:00 - 16:00</option>
                <option value="16:00 - 18:00">16:00 - 18:00</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Upload Prescription</button>
    </form>
</div>

@endsection
