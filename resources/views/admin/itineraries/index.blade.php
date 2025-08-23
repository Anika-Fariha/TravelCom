@extends('layouts.app')

@section('content')
<style>
    /* Force all text & table contents to be white */
    .itineraries-container,
    .itineraries-container * {
        color: white !important;
    }

    /* Make table dark so white text is visible */
    .itineraries-container .table {
        background-color: #212529 !important; /* Bootstrap dark background */
    }

    .itineraries-container .table th,
    .itineraries-container .table td {
        border-color: #444 !important; /* keep borders visible */
    }

    /* Alert white text */
    .itineraries-container .alert {
        background-color: #444 !important;
        color: white !important;
        border: none !important;
    }

    /* Buttons styled dark with white text */
    .itineraries-container .btn {
        background-color: #000 !important;
        color: white !important;
        border: 1px solid #666 !important;
    }

    .itineraries-container .btn:hover {
        background-color: #333 !important;
        color: white !important;
    }
</style>

<div class="container py-5 itineraries-container">
    <h1 class="text-center mb-4">All User Itineraries</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Itineraries Table -->
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Destination</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Budget</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itineraries as $itinerary)
                <tr>
                    <td>{{ $itinerary->user->name }}</td> 
                    <td>{{ $itinerary->destination }}</td>
                    <td>{{ \Carbon\Carbon::parse($itinerary->start_date)->format('F d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($itinerary->end_date)->format('F d, Y') }}</td>
                    <td>${{ number_format($itinerary->budget, 2) }}</td>
                    <td>
                        <a href="{{ route('admin.itineraries.show', $itinerary->id) }}" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
