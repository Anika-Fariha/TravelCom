@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Edit Group Trip</h1>

    <form action="{{ route('group_trips.update', $groupTrip->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Group Trip Name -->
        <div class="form-group mb-3">
            <label for="name" class="form-label">Group Trip Name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $groupTrip->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Destination -->
        <div class="form-group mb-3">
            <label for="destination" class="form-label">Destination</label>
            <select name="destination" id="destination" class="form-control @error('destination') is-invalid @enderror" required>
                <option value="" disabled selected>Select a Destination</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ old('destination', $groupTrip->destination) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
            @error('destination')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Start Date -->
        <div class="form-group mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $groupTrip->start_date) }}" required>
            @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- End Date -->
        <div class="form-group mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $groupTrip->end_date) }}" required>
            @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group mb-3">
            <label for="description" class="form-label">Description (Optional)</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Add any extra details here">{{ old('description', $groupTrip->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100 py-2">Update Group Trip</button>
    </form>
</div>
@endsection
