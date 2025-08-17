@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Your Notifications</h1>

    @if ($notifications->isEmpty())
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <p class="text-gray-500 text-lg">You have no notifications.</p>
        </div>
    @else
        <ul class="space-y-4">
            @foreach ($notifications as $notification)
                <li>
                    <div class="block bg-white shadow-md rounded-lg p-4 hover:shadow-lg transition-shadow duration-300 ease-in-out">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <!-- Notification Icon Logic -->
                                <span class="text-2xl" role="img" aria-label="{{ $notification->title }}">
                                    @if (str_contains(strtolower($notification->title), 'upvoted'))
                                        ⬆️
                                    @elseif (str_contains(strtolower($notification->title), 'downvoted'))
                                        ⬇️
                                    @elseif (str_contains(strtolower($notification->title), 'comment'))
                                        💬
                                    @else
                                        🔔
                                    @endif
                                </span>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h4 class="text-lg font-semibold text-gray-800 truncate">
                                    {{ $notification->title }}
                                </h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                <span class="text-xs text-gray-400 mt-2 inline-block">
                                    <!-- Time Formatting Logic -->

                                    @php
                                        $created_at = $notification->created_at; 
                                    @endphp

                                    @if ($created_at->diffInMinutes(now()) < 1)
                                        Just now
                                    @elseif ($created_at->diffInMinutes(now()) < 60)
                                        {{ round($created_at->diffInMinutes(now())) }} min ago
                                    @elseif ($created_at->diffInHours(now()) < 24)
                                        {{ round($created_at->diffInHours(now())) }} hours ago
                                    @else
                                        {{ $created_at->format('F d, Y h:i A') }}
                                    @endif

                                    
                                </span>
                            </div>

                            
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
