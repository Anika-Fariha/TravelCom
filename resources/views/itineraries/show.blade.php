@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Itinerary Title -->
    <h1 class="display-4 font-weight-bold text-white text-center mb-5">My Itinerary</h1>

    <!-- Itinerary Information Card -->
    <div class="card shadow-lg rounded-lg mb-5">
        <div class="card-body">
            <!-- Start Date -->
            <p class="lead mb-2"><strong>Start Date:</strong> <span class="text-muted">{{ \Carbon\Carbon::parse($itinerary->start_date)->format('F d, Y') }}</span></p>
            <!-- End Date -->
            <p class="lead mb-2"><strong>End Date:</strong> <span class="text-muted">{{ \Carbon\Carbon::parse($itinerary->end_date)->format('F d, Y') }}</span></p>
            <!-- Budget -->
            <p class="lead mb-2"><strong>Budget:</strong> <span class="text-success">${{ number_format($itinerary->budget, 2) }}</span></p>
            <!-- Description -->
            <p class="lead"><strong>Description:</strong> <span class="text-muted">{{ $itinerary->description }}</span></p>
        </div>
    </div>

    <!-- City Stops Section -->
    <h3 class="h4 font-weight-bold text-white mb-4">City Stops</h3>
    
    @if($itinerary->cityStops->isEmpty())
        <div class="alert alert-info text-center">
            No city stops added.
        </div>
    @else
        <ul class="list-group">
            @foreach($itinerary->cityStops as $cityStop)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-1 text-primary">{{ $cityStop->name }}</h5>
                        <p class="mb-1 text-muted">{{ $cityStop->description }}</p>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary btn-sm">Details</button>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

@endsection
