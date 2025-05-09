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
                    <li class="collection-tab {{ request()->get('tab') == 'Ibadah' ? 'active' : '' }}"><a href="?tab=Ibadah">Ibadah</a></li>
                    <li class="collection-tab {{ request()->get('tab') == 'Muamalah' ? 'active' : '' }}"><a href="?tab=Muamalah">Muamalah</a></li>
                    <li class="collection-tab {{ request()->get('tab') == 'Zakat' ? 'active' : '' }}"><a href="?tab=Zakat">Zakat</a></li>
                    <li class="collection-tab {{ request()->get('tab') == 'Lorem' ? 'active' : '' }}"><a href="?tab=Lorem">Lorem</a></li>
                </ul>
            </div>
        </div>
        <!-- Ibadah Content -->
        <div class="row">
            <div class="collection-content">
                <!-- Collection Cards -->
                <div class="collection-card">
                    <span class="collection-tag">Muamalah</span>
                    <p class="collection-date">22 April 2025</p>
                    <h3 class="collection-title">Bagaimana hukum shalat ketika sedang dalam perjalanan?</h3>
                    <p class="collection-preview">Saya sering bepergian untuk urusan bisnis. Bagaimana ketentuan shalat jamak dan qashar...</p>
                    <a href="#" class="collection-read-more">Selengkapnya</a>
                </div>
    
                <div class="collection-card">
                    <span class="collection-tag">Muamalah</span>
                    <p class="collection-date">22 April 2025</p>
                    <h3 class="collection-title">Bagaimana hukum shalat ketika sedang dalam perjalanan?</h3>
                    <p class="collection-preview">Saya sering bepergian untuk urusan bisnis. Bagaimana ketentuan shalat jamak dan qashar...</p>
                    <a href="#" class="collection-read-more">Selengkapnya</a>
                </div>
    
                <div class="collection-card">
                    <span class="collection-tag">Muamalah</span>
                    <p class="collection-date">22 April 2025</p>
                    <h3 class="collection-title">Bagaimana hukum shalat ketika sedang dalam perjalanan?</h3>
                    <p class="collection-preview">Saya sering bepergian untuk urusan bisnis. Bagaimana ketentuan shalat jamak dan qashar...</p>
                    <a href="#" class="collection-read-more">Selengkapnya</a>
                </div>
    
                <div class="collection-card">
                    <span class="collection-tag">Muamalah</span>
                    <p class="collection-date">22 April 2025</p>
                    <h3 class="collection-title">Bagaimana hukum shalat ketika sedang dalam perjalanan?</h3>
                    <p class="collection-preview">Saya sering bepergian untuk urusan bisnis. Bagaimana ketentuan shalat jamak dan qashar...</p>
                    <a href="#" class="collection-read-more">Selengkapnya</a>
                </div>
    
                <div class="collection-card">
                    <span class="collection-tag">Muamalah</span>
                    <p class="collection-date">22 April 2025</p>
                    <h3 class="collection-title">Bagaimana hukum shalat ketika sedang dalam perjalanan?</h3>
                    <p class="collection-preview">Saya sering bepergian untuk urusan bisnis. Bagaimana ketentuan shalat jamak dan qashar...</p>
                    <a href="#" class="collection-read-more">Selengkapnya</a>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Tab Navigation Functionality
        const collectionTabs = document.querySelectorAll('.collection-tab');
        const collectionContents = document.querySelectorAll('.tab-content');

        collectionTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const tabName = tab.getAttribute('data-tab');

                // Remove active class from all tabs and contents
                collectionTabs.forEach(t => t.classList.remove('active'));
                collectionContents.forEach(c => c.classList.remove('active'));

                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                document.getElementById(`${tabName}-content`).classList.add('active');
            });
        });

        // Search Functionality
        const searchInput = document.querySelector('.search-input');
        const collectionCards = document.querySelectorAll('.collection-card');

        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();

            collectionCards.forEach(card => {
                const title = card.querySelector('.collection-title').textContent.toLowerCase();
                const preview = card.querySelector('.collection-preview').textContent.toLowerCase();
                const tag = card.querySelector('.collection-tag').textContent.toLowerCase();

                if (title.includes(searchTerm) || preview.includes(searchTerm) || tag.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>

@endsection
