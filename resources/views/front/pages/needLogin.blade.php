@extends('front.layouts.app')

@section('title', 'Kamu harus login')

@section('content')
<div class="container">
    <div style="display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  text-align: center;">
        <img src="{{ asset('images/login_dulu.png') }}" alt="" srcset="">
        <div style="color: #16B8A8">
            <h1><b>Ooops...!</b></h1>
        <p>Masih dalam pengembangan</p>
        </div>
    </div>
</div>
@endsection
