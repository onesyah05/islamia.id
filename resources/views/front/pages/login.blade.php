@extends('front.layouts.app')

@section('title', 'Login - Islamia')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="">
            <div class="card border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h4 class="mb-3">Selamat Datang</h4>
                        <p class="text-muted">Silakan login untuk melanjutkan</p>
                    </div>
                    
                    <a href="{{ route('google.login') }}" class="btn btn-light w-100 py-2 mb-3 d-flex align-items-center justify-content-center gap-2 border">
                        <img src="https://www.google.com/favicon.ico" alt="Google" width="20" height="20">
                        <span>Login dengan Google</span>
                    </a>

                    <div class="text-center mt-4">
                        <p class="small text-muted">
                            Dengan login, Anda menyetujui <a href="#" class="text-decoration-none">Syarat & Ketentuan</a> kami
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-light {
        background-color: #16B8A8!important;
        color: white!important;
        transition: all 0.3s ease;
    }
    .btn-light:hover {
        background-color: #045750!important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .card {
        border-radius: 15px;
        background-color: #ffffff;
    }
    .text-muted {
        color: #4B5563 !important;
    }
    a {
        color: #16B8A8;
    }
    a:hover {
        color: #045750;
    }
</style>
@endsection