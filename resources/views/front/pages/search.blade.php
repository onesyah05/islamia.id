@extends('front.layouts.app')

@section('title', 'Search Questions')

@section('content')
@include('front.components.header_detail',['title'=> 'Pencarian'])
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Search Bar -->
            <form action="{{ route('search.questions') }}" method="GET">
                <div class="search-container mb-4">
                    <input 
                        type="text" 
                        name="q" 
                        class="search-input" 
                        placeholder="Ibadah sholat" 
                        value="{{ request('q') }}"
                    >
                    <button type="submit" class="search-button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Sorting Options -->
            <div class="sorting-options mb-3">
                <span class="sort-label">Urutakan berdasarkan:</span>
                <div class="sort-buttons">
                    <a href="{{ route('search.questions', ['q' => request('q'), 'sort_by' => 'relevance']) }}" 
                       class="sort-button {{ request('sort_by', 'relevance') == 'relevance' ? 'active' : '' }}">
                       Relevansi
                    </a>
                    <a href="{{ route('search.questions', ['q' => request('q'), 'sort_by' => 'date']) }}" 
                       class="sort-button {{ request('sort_by') == 'date' ? 'active' : '' }}">
                       Tanggal
                    </a>
                    <a href="{{ route('search.questions', ['q' => request('q'), 'sort_by' => 'views']) }}" 
                       class="sort-button {{ request('sort_by') == 'views' ? 'active' : '' }}">
                       Jumlah Baca
                    </a>
                </div>
            </div>

            <!-- Search Results -->
            <div class="search-results">
                @forelse($questions as $question)
                    <div class="result-card">
                        <div class="category-badge">
                            {{ $question->categories->first()->name ?? 'Umum' }}
                        </div>
                        <h3 class="result-title">
                            {{ $question->title }}
                        </h3>
                        <p class="result-preview">
                            {{ Str::limit(strip_tags($question->content), 150) }}
                        </p>
                        <div class="result-footer">
                            <a href="{{ route('questions.show', $question->slug) }}" class="read-more">
                                Selengkapnya
                            </a>
                            <span class="result-date">{{ $question->created_at->format('d F Y') }}</span>
                        </div>
                    </div>
                @empty
                <div style="display: flex;
                flex-direction: column;
                align-items: center;
                margin-top: -100px;
                justify-content: center;
                height: 100vh;
                text-align: center;">
                      <img src="{{ asset('images/null.png') }}" alt="" srcset="">
                      <div style="color: #16B8A8">
                          <h1><b>Ooops...!</b></h1>
                      <p>Tidak ada hasil yang ditemukan.</p>
                      </div>
                  </div>
                @endforelse
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-4 mb-5">
                @if($questions->hasMorePages())
                    <a href="{{ $questions->appends(['q' => request('q'), 'sort_by' => request('sort_by')])->nextPageUrl() }}" 
                       class="load-more-button" id="load-more">Lihat lebih banyak</a>
                @endif
            </div>
            
            <br><br><br><br>
            <!-- AJAX Script for Load More functionality -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const loadMoreBtn = document.getElementById('load-more');
                    if (loadMoreBtn) {
                        loadMoreBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const nextPageUrl = this.getAttribute('href');
                            
                            // Show loading indicator
                            this.innerHTML = 'Memuat...';
                            
                            fetch(nextPageUrl)
                                .then(response => response.text())
                                .then(html => {
                                    // Create a temporary element to parse the HTML
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');
                                    
                                    // Extract the new questions
                                    const newQuestions = doc.querySelectorAll('.result-card');
                                    const resultsContainer = document.querySelector('.search-results');
                                    
                                    // Append new questions to the results container
                                    newQuestions.forEach(question => {
                                        resultsContainer.appendChild(document.importNode(question, true));
                                    });
                                    
                                    // Extract the next page URL, if any
                                    const newLoadMoreBtn = doc.getElementById('load-more');
                                    if (newLoadMoreBtn) {
                                        loadMoreBtn.setAttribute('href', newLoadMoreBtn.getAttribute('href'));
                                        loadMoreBtn.innerHTML = 'Lihat lebih banyak';
                                    } else {
                                        // No more pages, remove the button
                                        loadMoreBtn.parentNode.removeChild(loadMoreBtn);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error loading more results:', error);
                                    loadMoreBtn.innerHTML = 'Lihat lebih banyak';
                                });
                        });
                    }
                });
            </script>
        </div>
    </div>
</div>
@endsection

<style>
    /* General Styles */
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }
    
    .container {
        max-width: 100%;
        padding: 0 15px;
    }
    
    /* Search Bar Styles */
    .search-container {
        position: relative;
        margin-top: 10px;
    }
    
    .search-input {
        width: 100%;
        padding: 12px 45px 12px 20px;
        border-radius: 50px;
        border: none;
        background-color: #10b981;
        color: white;
        font-size: 16px;
        outline: none;
    }
    
    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.8);
    }
    
    .search-button {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: white;
        font-size: 18px;
        padding: 10px;
        cursor: pointer;
    }
    
    /* Sorting Options */
    .sorting-options {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-top: 15px;
    }
    
    .sort-label {
        font-size: 14px;
        color: #666;
        margin-bottom: 8px;
    }
    
    .sort-buttons {
        display: flex;
        gap: 10px;
    }
    
    .sort-button {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 14px;
        text-decoration: none;
        color: #666;
        background-color: #f0f0f0;
        border: 1px solid #ddd;
    }
    
    .sort-button.active {
        background-color: #fff;
        border: 1px solid #10b981;
        color: #10b981;
    }
    
    /* Search Results */
    .search-results {
        margin-top: 20px;
    }
    
    .result-card {
        background-color: #fff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }
    
    .category-badge {
        display: inline-block;
        padding: 2px 8px;
        background-color: #16a085;
        color: white;
        border-radius: 4px;
        font-size: 12px;
        margin-bottom: 8px;
    }
    
    .result-title {
        font-size: 16px;
        font-weight: 600;
        margin-top: 0;
        margin-bottom: 8px;
        color: #333;
    }
    
    .result-preview {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    
    .result-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .read-more {
        color: #10b981;
        font-size: 14px;
        text-decoration: none;
    }
    
    .result-date {
        font-size: 12px;
        color: #999;
    }
    
    /* Load More Button */
    .load-more-button {
        display: inline-block;
        color: #10b981;
        text-decoration: none;
        font-size: 14px;
        padding: 8px 16px;
    }
    
    /* No Results */
    .no-results {
        text-align: center;
        padding: 30px 0;
        color: #666;
    }
</style>