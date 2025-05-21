@extends('front.layouts.app')

@section('title', 'Halaman Bookmark')

@section('content')
    <div class="container">
        <div class="row" style="margin-top:20px">
            {{-- <div class="head-home"> --}}
            <form action="" method="get">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Cari koleksi kamu">
                    <div class="search-icon"><i class="fa fa-search"></i></div>
                </div>
            </form>
            {{-- </div> --}}
        </div>
        <br>
        <div class="row">
            <div class="collection-tabs-container">
                <ul class="collection-tabs">
                    @foreach($categories as $category)
                        <li class="collection-tab {{ request()->get('category') == $category->id ? 'active' : '' }}">
                            <a href="?category={{ $category->id }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="collection-content">
                @forelse($bookmarks as $bookmark)
                    <div class="collection-card">
                        @foreach($bookmark->question->categories as $category)
                            <span class="collection-tag">{{ $category->name }}</span>
                        @endforeach
                        {{-- <p class="collection-date">{{ $bookmark->question->created_at->format('d F Y') }}</p> --}}
                        <h3 class="collection-title">{{ $bookmark->question->title }}</h3>
                        <p class="collection-preview">{{ Str::limit(strip_tags($bookmark->question->content), 100) }}</p>
                        <small>{{ $bookmark->question->created_at->format('d F Y') }}</small>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('questions.show', $bookmark->question->slug) }}" class="collection-read-more">Selengkapnya</a>
                            <form action="{{ route('bookmarks.destroy', $bookmark->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center">
                        <p>Belum ada bookmark yang disimpan</p>
                    </div>
                @endforelse

                <div class="d-flex justify-content-center mt-4">
                    {{ $bookmarks->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search Functionality
        const searchInput = document.querySelector('.search-input');
        const collectionCards = document.querySelectorAll('.collection-card');

        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();

            collectionCards.forEach(card => {
                const title = card.querySelector('.collection-title').textContent.toLowerCase();
                const preview = card.querySelector('.collection-preview').textContent.toLowerCase();
                const tags = Array.from(card.querySelectorAll('.collection-tag')).map(tag => tag.textContent.toLowerCase());

                if (title.includes(searchTerm) || 
                    preview.includes(searchTerm) || 
                    tags.some(tag => tag.includes(searchTerm))) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
@endsection
