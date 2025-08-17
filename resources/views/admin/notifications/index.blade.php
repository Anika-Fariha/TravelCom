@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Send Notification to All Users</h1>

    <form action="{{ route('admin.sendNotification') }}" method="POST">
        @csrf

        <!-- Notification Title -->
        <div class="mb-4">
            <label for="title" class="block text-lg font-medium text-gray-700">Notification Title</label>
            <input type="text" name="title" id="title" class="form-control mt-1 block w-full" required>
        </div>

        <!-- Notification Message -->
        <div class="mb-4">
            <label for="message" class="block text-lg font-medium text-gray-700">Notification Message</label>
            <textarea name="message" id="message" rows="5" class="form-control mt-1 block w-full" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send Notification</button>
    </form>
    
    <h1 class="text-3xl font-bold text-gray-800 mb-6">All Notifications</h1>

    @if($notifications->isEmpty())
        <p>No notifications available.</p>
    @else
        <ul>
            @foreach ($notifications as $notification)
                <li class="bg-white p-4 mb-4 shadow-md rounded-md">
                    <h4 class="font-semibold">{{ $notification->title }}</h4>
                    <p>{{ $notification->message }}</p>
                    <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection

