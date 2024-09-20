@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')

<div class="container">
    <h1>Dashboard</h1>

    <p>Welcome to your dashboard!</p>

    @if(Auth::user()->role === 'pharmacy')
    <p>You are logged in as a Pharmacy User.</p>
    <a href="{{ route('pharmacy.index') }}" class="btn btn-primary">View Prescriptions</a>
    @elseif(Auth::user()->role === 'user')
    <p>You are logged in as a Regular User.</p>
    <a href="{{ route('user.prescriptions') }}" class="btn btn-primary">View My Prescriptions</a>
    @endif

    <p>Here you can manage your account and view your activities.</p>
</div>

@endsection