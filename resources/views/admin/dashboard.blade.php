@extends('layouts.app')

@section('content')
<div class="container py-5 text-white">  {{-- added text-white --}}
    <h1 class="display-4 text-center mb-4">Admin Dashboard</h1>

    <div class="row">
        
        <div class="col-md-4">
            <div class="card shadow-sm bg-dark"> {{-- added bg-dark for contrast --}}
                <div class="card-body">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">Create, delete, or view users on the platform.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary w-100">Manage Users</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm bg-dark">
                <div class="card-body">
                    <h5 class="card-title">View Itineraries</h5>
                    <p class="card-text">View itineraries created by users.</p>
                    <a href="{{ route('admin.itineraries.index') }}" class="btn btn-primary w-100">View Itineraries</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Send Notifications</h5>
                    <p class="card-text">Send notifications to all users of the platform.</p>
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-primary w-100">Send Notification</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mt-4 card shadow-sm bg-dark">
                <div class="card-body">
                    <h5 class="card-title">View Group Trips</h5>
                    <p class="card-text">View all group trips created by users.</p>
                    <a href="{{ route('admin.group_trips.index') }}" class="btn btn-primary w-100">View Group Trips</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
