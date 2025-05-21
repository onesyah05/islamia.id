@extends('front.layouts.app')

@section('title', 'Account Detail - Islamia')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card border-0">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                             alt="Profile" 
                             class="rounded-circle mb-3"
                             style="width: 100px; height: 100px; object-fit: cover;">
                        <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                        <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        <a href="{{ route('account') }}" class="list-group-item list-group-item-action">
                            <i class="fa fa-user me-2"></i> Profile
                        </a>
                        <a href="{{ route('account.detail') }}" class="list-group-item list-group-item-action active">
                            <i class="fa fa-chart-bar me-2"></i> Statistik
                        </a>
                        <a href="{{ route('questions.index') }}" class="list-group-item list-group-item-action">
                            <i class="fa fa-question-circle me-2"></i> Pertanyaan Saya
                        </a>
                        <a href="{{ route('bookmarks.index') }}" class="list-group-item list-group-item-action">
                            <i class="fa fa-bookmark me-2"></i> Bookmark
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fa fa-bell me-2"></i> Notifikasi
                        </a>
                        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger">
                            <i class="fa fa-sign-out me-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 h-100">
                        <div class="card-body text-center">
                            <h3 class="mb-2">{{ Auth::user()->questions()->count() }}</h3>
                            <p class="text-muted mb-0">Pertanyaan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 h-100">
                        <div class="card-body text-center">
                            <h3 class="mb-2">{{ Auth::user()->answers()->count() }}</h3>
                            <p class="text-muted mb-0">Jawaban</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 h-100">
                        <div class="card-body text-center">
                            <h3 class="mb-2">{{ Auth::user()->bookmarks()->count() }}</h3>
                            <p class="text-muted mb-0">Bookmark</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="mb-4">Aktivitas Terakhir</h4>
                    
                    <div class="list-group list-group-flush">
                        @forelse(Auth::user()->questions()->latest()->take(5)->get() as $question)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $question->title }}</h6>
                                        <small class="text-muted">{{ $question->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $question->answers()->count() }} jawaban</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">Belum ada aktivitas</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .list-group-item {
        border: none;
        padding: 0.75rem 1rem;
    }
    .list-group-item.active {
        background-color: #16B8A8;
        border-color: #16B8A8;
    }
    .list-group-item-action:hover {
        background-color: #f8f9fa;
    }
    .card {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .badge {
        background-color: #16B8A8 !important;
    }
</style>
@endsection 