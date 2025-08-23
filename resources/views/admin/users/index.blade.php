@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">User Management</h1>

    <!-- Button to create new user -->
    <div class="text-center mb-4">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
    </div>

    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Users Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="text-white">{{ $user->name }}</td>
                    <td class="text-white">{{ $user->email }}</td>
                    <td>
                        <!-- Delete User Form -->
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger text-white">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
