@extends('layouts.app')

@section('content')
<style>
    /* Force all text inside form to be white */
    .user-form-container,
    .user-form-container * {
        color: white !important;
    }

    /* Dark form inputs with white text */
    .user-form-container .form-control {
        background-color: #222 !important;
        color: white !important;
        border: 1px solid #555 !important;
    }

    .user-form-container .form-control:focus {
        background-color: #333 !important;
        color: white !important;
        border-color: #888 !important;
        box-shadow: none !important;
    }

    /* Button styling */
    .user-form-container .btn {
        background-color: #000 !important;
        color: white !important;
        border: 1px solid #666 !important;
    }

    .user-form-container .btn:hover {
        background-color: #333 !important;
        color: white !important;
    }

    /* Validation error messages */
    .user-form-container .invalid-feedback {
        color: #ff6b6b !important; /* keep errors visible in red */
    }
</style>

<div class="container py-5 user-form-container">
    <h1 class="text-center mb-4">Add New User</h1>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn mt-3">Add User</button>
    </form>
</div>
@endsection
