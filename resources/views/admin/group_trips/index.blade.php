@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">All Group Trips</h1>

    @if ($groupTrips->isEmpty())
        <p class="text-center">No group trips created yet.</p>
    @else
        <table class="table table-striped">
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
                        <td>{{ $groupTrip->user->name }}</td> <!-- User who created the trip -->
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
