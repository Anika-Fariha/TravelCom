@extends('layouts.app')

@section('content')
<style>
    /* Force white text for this page only */
    .group-trips-container, 
    .group-trips-container * {
        color: white !important;
    }
</style>

<div class="container py-5 group-trips-container">
    <h1 class="text-3xl font-bold mb-6">All Group Trips</h1>

    @if ($groupTrips->isEmpty())
        <p class="text-center">No group trips created yet.</p>
    @else
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Trip Name</th>
                    <th>Destination</th>
                    <th>Created By</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupTrips as $groupTrip)
                    <tr>
                        <td>{{ $groupTrip->name }}</td>
                        <td>{{ $groupTrip->destination }}</td>
                        <td>{{ $groupTrip->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($groupTrip->start_date)->format('F d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($groupTrip->end_date)->format('F d, Y') }}</td>
                        <td>
                            <a href="{{ route('group_trips.show', $groupTrip->id) }}" class="btn btn-info btn-sm">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
