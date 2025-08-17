@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
    }

    .pastel-hero {
        background: linear-gradient(to bottom right, #a0d8ef, #c5f6fa, #d9fdd3);

        min-height: calc(100vh - 100px); /* Account for header */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        padding: 3rem;
        text-align: center;
        max-width: 700px;
        width: 100%;
    }

    .glass-card h1 {
        font-size: 2.5rem;
        font-weight: bold;
        color: #69bce6;
    }

    .glass-card p {
        font-size: 1.2rem;
        color: #333;
        margin: 1rem 0;
    }

    .glass-card a.btn {
        background-color: #aee1f9;
        color: white;
        border: none;
        font-weight: bold;
        padding: 0.75rem 2rem;
        border-radius: 30px;
        transition: background-color 0.3s ease;
    }

    .glass-card a.btn:hover {
        background-color: #92d3f0;
        color: white;
    }
</style>

<div class="pastel-hero">
    <div class="glass-card">
        <h1>Welcome to <span style="color: #fcbad3;">TravelCom</span> 🌸</h1>
        <p>Plan your dream trips and share your travel magic!</p>
        @guest
            <a href="{{ route('register') }}" class="btn">Register now!</a>
        @else
            <a href="{{ url('/home') }}" class="btn">Go to Dashboard</a>
        @endguest
    </div>
</div>
@endsection
