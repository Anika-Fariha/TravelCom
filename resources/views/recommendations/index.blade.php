@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Recommendations Inbox</h1>

        <!-- Display success message if available -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- List of Recommendations -->
        @foreach($inbox as $recommendation)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $recommendation->sender->name }} - {{ $recommendation->itinerary->destination }}</h5>
                    <p class="card-text">{{ $recommendation->message }}</p>
                    <p>Status: {{ ucfirst($recommendation->status) }}</p>
                    <!-- Correct route name used for marking as read -->
                    <form method="POST" action="{{ route('recommendations.read', $recommendation->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-info">Mark as Read</button>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        {{ $inbox->links() }}
    </div>
@endsection
