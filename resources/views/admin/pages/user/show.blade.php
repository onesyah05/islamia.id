@extends('admin.layouts.app')

@section('title', 'User Details')
@section('description', 'Display user details')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">User Details</h5>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Back to Users List</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ $user->role }}</p>
                <p><strong>Registered At:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>
            {{-- Add more user details here if needed --}}
        </div>
         <div class="mt-3">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
            {{-- Add delete form here --}}
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection 