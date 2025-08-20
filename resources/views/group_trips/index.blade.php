@extends('layouts.app')

@section('content')
<style>
/* Add a subtle hover effect to cards */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Ensure consistent button group layout */
.button-group {
    display: flex;
    justify-content: flex-start;
    gap: 8px; /* spacing between buttons */
    align-items: stretch; /* Make all items stretch to the same height */
}

/* Make all buttons and their container forms in the group the same size */
.button-group a,
.button-group form {
    flex: 1; /* Allow all items to grow and shrink equally */
}

/* Ensure consistent button styling within the group, overriding any default styles */
.button-group .btn {
    width: 100%; /* Make buttons fill their container */
    font-weight: 500;
    text-align: center;
    /* Explicitly set consistent padding and a fixed height to ensure uniformity */
    padding: .375rem .75rem;
    height: 38px;
}
</style>

<div class="container py-5">
    <h1 class="display-4 font-weight-bold text-white text-center mb-4">My Group Trips</h1>

    <!-- Button to Create New trip -->
    <div class="text-center mb-4">
        <a href="{{ route('group_trips.create') }}" class="btn btn-primary btn-lg">Create New Group Trip</a>
    </div>

    @if($groupTrips->isEmpty())
        <p class="text-center text-muted">You haven't created any group trips yet.</p>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($groupTrips as $groupTrip)
                <div class="col">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $groupTrip->name }}</h5>
                            <p class="card-text text-muted mb-2">Destination: {{ $groupTrip->destination }}</p>
                            <p class="card-text text-muted mb-4">
                                From: {{ \Carbon\Carbon::parse($groupTrip->start_date)->format('F d, Y') }}
                                to {{ \Carbon\Carbon::parse($groupTrip->end_date)->format('F d, Y') }}
                            </p>
                            
                            <!-- Button group for actions -->
                            <div class="button-group">
                                <!-- View Button -->
                                <a href="{{ route('group_trips.show', $groupTrip->id) }}" class="btn btn-info">View</a>
                                <!-- Edit Button -->
                                <a href="{{ route('group_trips.edit', $groupTrip->id) }}" class="btn btn-warning">Edit</a>
                                
                                <!-- Delete Button Form -->
                                <form action="{{ route('group_trips.destroy', $groupTrip->id) }}" method="POST" class="delete-form m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this group trip?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>



<!-- Accepted Group Trips Section -->
<div class="container py-5">
    <h1 class="display-4 font-weight-bold text-white text-center mb-4">Accepted Group Trips</h1>
    @if($acceptedGroupTrips->isEmpty())
        <p class="text-center text-muted">You haven't accepted any group trip invitations yet.</p>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($acceptedGroupTrips as $groupTrip)
                <div class="col">
                    <div class="card shadow-lg rounded-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $groupTrip->name }}</h5>
                            <p class="card-text text-muted">Destination: {{ $groupTrip->destination }}</p>
                            <p class="card-text text-muted">Start Date: {{ \Carbon\Carbon::parse($groupTrip->start_date)->format('F d, Y') }}</p>
                            <p class="card-text text-muted mb-4">End Date: {{ \Carbon\Carbon::parse($groupTrip->end_date)->format('F d, Y') }}</p>
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
    <h1 class="display-4 font-weight-bold text-white text-center mb-4">Group Trip Invitations</h1>

    @if($invitations->isEmpty())
        <p class="text-center text-muted">You have no pending invitations.</p>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($invitations as $invitation)
                <div class="col">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $invitation->groupTrip->name }}</h5>
                            <p class="card-text text-muted">Destination: {{ $invitation->groupTrip->destination }}</p>
                            <p class="card-text text-muted">Start Date: {{ \Carbon\Carbon::parse($invitation->groupTrip->start_date)->format('F d, Y') }}</p>
                            <p class="card-text text-muted mb-4">End Date: {{ \Carbon\Carbon::parse($invitation->groupTrip->end_date)->format('F d, Y') }}</p>

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
