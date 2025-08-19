@extends('layouts.app')

@section('content')
<style>
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Flexbox for buttons */
.button-group {
    display: flex;
    gap: 8px; /* equal spacing between buttons */
}

.button-group a,
.button-group .delete-form button {
    flex: 1; /* make all buttons equal width */
}

/* Ensure consistent button size */
.button-group .btn {
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
}
</style>

<div class="container py-5">
    <h1 class="display-4 font-weight-bold text-white text-center mb-4">My Itineraries</h1>

    <!-- Button to Create New Itinerary -->
    <div class="text-center mb-4">
        <a href="{{ route('itineraries.create') }}" class="btn btn-primary btn-lg">Create New Itinerary</a>
    </div>

    <!-- Check if there are itineraries -->
    @if($itineraries->isEmpty())
        <p class="text-center text-muted">You haven't created any itineraries yet.</p>
    @else
        <!-- Iterate through itineraries and display each one -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($itineraries as $itinerary)
                <div class="col">
                    <div class="card shadow-sm rounded-3">
                        @if($itinerary->city && $itinerary->city->image)
                            <img src="{{ asset('assets/images/'.$itinerary->city->image) }}" class="card-img-top" alt="City Image" style="object-fit: cover; height: 150px;">
                        @else
                            <img src="{{ asset('assets/images/cities-01.jpg') }}" class="card-img-top" alt="Default City Image" style="object-fit: cover; height: 150px;">
                        @endif
                        <div class="card-body p-3">
                            <h5 class="card-title">{{ $itinerary->city->name }}</h5>
                            <p class="card-text text-muted">
                                From: {{ \Carbon\Carbon::parse($itinerary->start_date)->format('F d, Y') }} 
                                to {{ \Carbon\Carbon::parse($itinerary->end_date)->format('F d, Y') }}
                            </p>
                            <p class="card-text"><strong>Budget:</strong> ${{ number_format($itinerary->budget, 2) }}</p>

                            <!-- Button group -->
                            <div class="button-group">
                                <a href="{{ route('itineraries.show', $itinerary->id) }}" class="btn btn-info">View</a>
                                <a href="{{ route('itineraries.edit', $itinerary->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('itineraries.destroy', $itinerary->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
