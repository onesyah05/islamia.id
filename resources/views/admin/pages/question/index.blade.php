@extends('admin.layouts.app')

@section('title', 'Questions')
@section('description', 'Manage questions')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Question List</h5>
        <a href="{{ route('dashboard.questions.create') }}" class="btn btn-primary">Add New Question</a>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.questions.index') }}" method="GET">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search questions..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Filter by Status</option>
                        <option value="answered" {{ request('status') == 'answered' ? 'selected' : '' }}>Answered</option>
                        <option value="unanswered" {{ request('status') == 'unanswered' ? 'selected' : '' }}>Unanswered</option>
                    </select>
                </div>
                 <div class="col-md-3">
                    <button class="btn btn-secondary" type="submit">Apply Filter</button>
                    @if(request('search') || request('status'))
                         <a href="{{ route('dashboard.questions.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Asked By</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $question)
                    <tr>
                        <td>{{ ($questions->currentPage() - 1) * $questions->perPage() + $loop->iteration }}</td>
                        <td>{{ Str::limit($question->title, 50) }}</td>
                        <td>{{ $question->user->name ?? 'N/A' }}</td>
                        <td>{{ $question->categories->pluck('name')->join(', ') ?? 'Uncategorized' }}</td>
                        <td>
                            <span class="badge bg-label-{{ $question->answers->count() > 0 ? 'success' : 'warning' }}">
                                {{ $question->answers->count() > 0 ? 'Answered' : 'Unanswered' }}
                            </span>
                        </td>
                        <td>{{ $question->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('questions.show', $question->slug) }}" class="btn btn-sm btn-info">View</a>
                             @if(auth()->user()->role === 'admin' || (auth()->user()->role === 'ustadz' && $question->answers->where('user_id', auth()->id())->count() > 0) || (auth()->user()->role === 'ustadz' && $question->answers->count() == 0 && $question->categories->whereIn('id', auth()->user()->categories->pluck('id'))->count() > 0))
                                <a href="{{ route('dashboard.questions.edit', $question->id) }}" class="btn btn-sm btn-warning">Edit/Answer</a>
                             @endif
                            @if(auth()->user()->role === 'admin')
                                <form action="{{ route('dashboard.questions.destroy', $question->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No questions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $questions->links() }}
        </div>
    </div>
</div>
@endsection 