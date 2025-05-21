@extends('admin.layouts.app')

@section('title', 'Question Details')
@section('description', 'Display question details and answer')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Question Details</h5>
        <a href="{{ route('dashboard.questions.index') }}" class="btn btn-primary">Back to Questions List</a>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Title:</strong> {{ $question->title }}
        </div>
        <div class="mb-3">
            <strong>Asked By:</strong> {{ $question->user->name ?? 'N/A' }}
        </div>
        <div class="mb-3">
            <strong>Category:</strong> {{ $question->categories->first()->name ?? 'Uncategorized' }}
        </div>
        <div class="mb-3">
            <strong>Status:</strong>
            <span class="badge bg-label-{{ $question->answers->count() > 0 ? 'success' : 'warning' }}">
                {{ $question->answers->count() > 0 ? 'Answered' : 'Unanswered' }}
            </span>
        </div>
         <div class="mb-3">
            <strong>Asked At:</strong> {{ $question->created_at->format('d/m/Y H:i') }}
        </div>
        <div class="mb-3">
            <strong>Question:</strong>
            <p>{{ $question->content }}</p>
        </div>

        @if($question->answers->count() > 0)
        <hr>
        <div class="mb-3">
            <strong>Answer:</strong>
             {{-- Display answer content, handle potential HTML from rich text editor --}}
            <p>{!! $question->answers->first()->content !!}</p>
        </div>
        <div class="mb-3">
            <strong>Answered By:</strong> {{ $question->answers->first()->user->name ?? 'N/A' }}
        </div>
         <div class="mb-3">
            <strong>Answered At:</strong> {{ $question->answers->first()->created_at->format('d/m/Y H:i') }}
        </div>
        @else
        <div class="alert alert-info">No answer yet for this question.</div>
        @endif

        <div class="mt-3">
            @if(auth()->user()->role === 'admin' || (auth()->user()->role === 'ustadz' && $question->answers->where('user_id', auth()->id())->count() > 0) || (auth()->user()->role === 'ustadz' && $question->answers->count() == 0 && $question->categories->whereIn('id', auth()->user()->categories->pluck('id'))->count() > 0))
                <a href="{{ route('dashboard.questions.edit', $question->id) }}" class="btn btn-warning">{{ $question->answers->count() > 0 ? 'Edit Answer' : 'Add Answer' }}</a>
            @endif
             @if(auth()->user()->role === 'admin')
                <form action="{{ route('dashboard.questions.destroy', $question->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
             @endif
        </div>
    </div>
</div>
@endsection 