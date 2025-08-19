@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Send a Recommendation</h1>

        <!-- Show success message if available -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form to send recommendation -->
        <form method="POST" action="{{ route('recommendations.store') }}">
            @csrf
            <div class="form-group">
                <label for="receiver_id">Receiver</label>
                <select name="receiver_id" id="receiver_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="itinerary_id">Itinerary</label>
                <select name="itinerary_id" id="itinerary_id" class="form-control" required>
                    @foreach($itineraries as $itinerary)
                        <option value="{{ $itinerary->id }}">
                            {{ $itinerary->destination }} 
                            ({{ $itinerary->start_date }} to {{ $itinerary->end_date }} - Budget: {{ $itinerary->budget }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="message">Recommendation Message</label>
                <textarea name="message" id="message" class="form-control" maxlength="255"></textarea>
            </div>
            <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Send Recommendation</button>
        </form>

        <!-- Inbox -->
        <h2>Inbox</h2>
        <ul>
            @foreach($inbox as $recommendation)
                <li>
                    <strong>{{ $recommendation->sender->name }}:</strong>
                    <p>{{ $recommendation->message }}</p>
                    <span>Status: {{ ucfirst($recommendation->status) }}</span>
                    @if($recommendation->status === 'unread')
                        <form method="POST" action="{{ route('recommendations.read', $recommendation->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-info">Mark as Read</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>

        <!-- Pagination for inbox -->
        {{ $inbox->links() }}
    </div>
@endsection
