@extends('front.layouts.app')

@section('title', 'Halaman Beranda')

@section('content')
<div class="container">
    <div class="row">
        <div class="head-home">
            <form action="" method="get">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Cari tahu tentang islam">
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
</div>
@endsection
