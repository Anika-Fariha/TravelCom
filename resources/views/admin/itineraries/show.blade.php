@extends('layouts.app')

@section('content')
<style>
    /* Force white text only inside itinerary details */
    .itinerary-container, 
    .itinerary-container * {
        color: black !important;
    }
</style>

<div class="container py-5 itinerary-container">
    <h1 class="text-center mb-4" style="color: white !important;">Itinerary Details</h1>

    <!-- Itinerary Details -->
    <div class="card bg-white"> {{-- make card background dark so white text is visible --}}
        <div class="card-body">
            <h5 class="card-title">{{ $itinerary->destination }}</h5>
            <p class="card-text"><strong>User:</strong> {{ $itinerary->user->name }}</p>
            <p class="card-text"><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($itinerary->start_date)->format('F d, Y') }}</p>
            <p class="card-text"><strong>End Date:</strong> {{ \Carbon\Carbon::parse($itinerary->end_date)->format('F d, Y') }}</p>
            <p class="card-text"><strong>Budget:</strong> ${{ number_format($itinerary->budget, 2) }}</p>
            <p class="card-text"><strong>Description:</strong> {{ $itinerary->description }}</p>
        </div>
    </div>

    <a href="{{ route('admin.itineraries.index') }}" class="btn btn-secondary mt-4">Back to All Itineraries</a>
</div>
@endsection
