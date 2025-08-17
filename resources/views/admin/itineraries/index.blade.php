@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">All User Itineraries</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Itineraries Table -->
    <table class="table table-striped">
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
