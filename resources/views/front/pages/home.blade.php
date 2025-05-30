@extends('front.layouts.app')

@section('title', 'Halaman Beranda')

@section('content')
<div class="container">
    <div class="row">
        <div class="head-home">
            <form action="{{ route('search.questions') }}" method="GET">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Cari tahu tentang islam" name="q">
                    <div class="search-icon"><i class="fa fa-search"></i></div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="feature-card-container">
                <div class="feature-card">
                  <div class="card-content">
                    <div class="card-label">Kelas Populer</div>
                    <h2 class="card-title">Antara Dakwah & Nafkah</h2>
                    <p class="card-subtitle">Menjalani dua kewajiban apakah harus berten-tangan?</p>
                    <a href="#" class="card-button">Daftar Sekarang</a>
                  </div>
                </div>
                <div class="card-image-container">
                  <img src="{{ asset('images/ustadz.png') }}" alt="Ustadz" class="card-image">
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
      <div class="col">
        <div class="title-bar">
          <p class="kiri"><b>Pertanyaan Terbaru</b></p>
          <a href="#" class="kanan">Lihat semua &nbsp<i class="fa fa-angle-right"></i></a>
        </div>        
      </div>
    </div>
    <div class="row">
      <div class="container-horizontal">
        @foreach ($latestQuestions as $question)
        <div class="card">
          <div class="card-body">
            <div class="title-bar-card">
              <span class="kiri">{{ $question->categories[mt_rand(0,count($question->categories)-1)]->name }}</span>
              <a href="#" class="kanan">{{ $question->created_at->format('d F Y') }}</a>
            </div>
            <div class="content-card">
              <span class="title"><b>{{ $question->title }}</b></span><br>
              <span class="des">{{ Str::limit($question->content, 100) }}</span><br>
              <a href="{{ route('questions.show', $question->slug) }}" class="detail">Selengkapnya</a>
            </div>  
          </div>
        </div> 
        @endforeach
      </div>
    </div>
    
    <div class="row">
      <div class="col">
        <div class="title-bar">
          <p class="kiri"><b>Pertanyaan Populer</b></p>
          <a href="#" class="kanan">Lihat semua &nbsp<i class="fa fa-angle-right"></i></a>
        </div>        
      </div>
    </div>
    <div class="row">
      <div class="container-horizontal">
        @foreach ($popularQuestions as $question)
        <div class="card">
          <div class="card-body">
            <div class="title-bar-card">
              <span class="kiri">{{ $question->categories[mt_rand(0,count($question->categories)-1)]->name }}</span>
              <a href="#" class="kanan">{{ $question->created_at->format('d F Y') }}</a>
            </div>
            <div class="content-card">
              <span class="title"><b>{{ $question->title }}</b></span><br>
              <span class="des">{{ Str::limit($question->content, 100) }}</span><br>
              <a href="{{ route('questions.show', $question->slug) }}" class="detail">Selengkapnya</a>
            </div>  
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col">
        <div class="title-bar">
          <p class="kiri"><b>Rekomendasi Kelas</b></p>
          <a href="#" class="kanan">Lihat semua &nbsp<i class="fa fa-angle-right"></i></a>
        </div>        
      </div>
    </div>
    <div class="row">
      <div class="container-horizontal">
        @for ($i = 0; $i < 10; $i++)
        <div class="promo-card">
          <div class="promo-card-img">
            <img src="https://via.placeholder.com/100x140.png?text=Poster" alt="Poster Quran" />
          </div>
          <div class="promo-card-content">
            <div class="promo-card-title">Lancar Quran 30 Hari</div>
            <div class="promo-card-desc">
              Saya sering bepergian untuk urusan bisnis. Bagaimana ketentuan shalat jamak dan qashar...
            </div>
            <div class="promo-card-footer">
              <span class="date">22 April 2025</span> <span class="status">| ONLINE</span>
            </div>
          </div>
        </div>
        @endfor
      </div>
    </div>
    
    <br>
    <br>
    <br>
    
</div>

@endsection