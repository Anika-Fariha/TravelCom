@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="display-4 text-center mb-4">{{ $groupTrip->name }} Group Trip</h1>

    <!-- Group Trip Details -->
    <div class="card shadow-lg rounded-3 mb-4">
        <div class="card-body">
            <p><strong>Destination:</strong> {{ $groupTrip->destination }}</p>
            <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($groupTrip->start_date)->format('F d, Y') }}</p>
            <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($groupTrip->end_date)->format('F d, Y') }}</p>
            <p><strong>Description:</strong> {{ $groupTrip->description }}</p>
        </div>
    </div>

    <!-- Invitations Section -->
    <h3>Invitations</h3>
    @if($groupTrip->invitations->isEmpty())
        <p>No invitations sent yet.</p>
    @else
        <ul class="list-group">
            @foreach($groupTrip->invitations as $invitation)
                <li class="list-group-item">
                    <strong>{{ $invitation->friend->name }}</strong> - 
                    <span class="text-muted">{{ $invitation->status }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
