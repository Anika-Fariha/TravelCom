@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">My Group Trips</h1>

    <!-- Button to Create New trip -->
    <div class="text-center mb-4">
        <a href="{{ route('group_trips.create') }}" class="btn btn-primary btn-lg">Create New Group Trip</a>
    </div>

    @if($groupTrips->isEmpty())
        <p class="text-center">You haven't created any group trips yet.</p>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($groupTrips as $groupTrip)
                <div class="col">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $groupTrip->name }}</h5>
                            <p class="card-text">Destination: {{ $groupTrip->destination }}</p>
                            <p class="card-text">From: {{ \Carbon\Carbon::parse($groupTrip->start_date)->format('F d, Y') }} to {{ \Carbon\Carbon::parse($groupTrip->end_date)->format('F d, Y') }}</p>
                            <a href="{{ route('group_trips.show', $groupTrip->id) }}" class="btn btn-info btn-sm">View</a>

                            <!-- Edit Button -->
                            <a href="{{ route('group_trips.edit', $groupTrip->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Delete Button -->
                            <form action="{{ route('group_trips.destroy', $groupTrip->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this group trip?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Accepted Group Trips Section -->
<div class="container py-5">
    <h1 class="text-center mb-4">Accepted Group Trips</h1>
    @if($acceptedGroupTrips->isEmpty())
        <p class="text-center">You haven't accepted any group trip invitations yet.</p>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($acceptedGroupTrips as $groupTrip)
                <div class="col">
                    <div class="card shadow-lg rounded-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $groupTrip->name }}</h5>
                            <p class="card-text">Destination: {{ $groupTrip->destination }}</p>
                            <p class="card-text">Start Date: {{ \Carbon\Carbon::parse($groupTrip->start_date)->format('F d, Y') }}</p>
                            <p class="card-text">End Date: {{ \Carbon\Carbon::parse($groupTrip->end_date)->format('F d, Y') }}</p>
                            <a href="{{ route('group_trips.show', $groupTrip->id) }}" class="btn btn-info">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Group Trip Invitations -->
<div class="container py-5">
    <h1 class="text-center mb-4">Group Trip Invitations</h1>

    @if($invitations->isEmpty())
        <p class="text-center">You have no pending invitations.</p>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($invitations as $invitation)
                <div class="col">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $invitation->groupTrip->name }}</h5>
                            <p class="card-text">Destination: {{ $invitation->groupTrip->destination }}</p>
                            <p class="card-text">Start Date: {{ \Carbon\Carbon::parse($invitation->groupTrip->start_date)->format('F d, Y') }}</p>
                            <p class="card-text">End Date: {{ \Carbon\Carbon::parse($invitation->groupTrip->end_date)->format('F d, Y') }}</p>

                            <!-- Accept/Reject Buttons -->
                            <form action="{{ route('group_trips.acceptInvitation', $invitation->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Accept</button>
                            </form>

                            <form action="{{ route('group_trips.rejectInvitation', $invitation->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
