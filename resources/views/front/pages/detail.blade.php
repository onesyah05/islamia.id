@extends('front.layouts.app')
@section('meta')
    <meta property="og:title" content="{{ $question->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($question->content), 200) }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $question->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($question->content), 200) }}">
    @if($question->categories->isNotEmpty())
        <meta property="article:tag" content="{{ $question->categories->pluck('name')->join(', ') }}">
    @endif
    <meta property="article:published_time" content="{{ $question->created_at->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $question->updated_at->toIso8601String() }}">
@endsection

<style>
        .button-container {
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        
        .teal-button {
            padding: 10px;
            background-color: #16B8A8;
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .teal-button:hover {
            background-color: #18c194;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
</style>

@section('title', 'Detail')

@section('content')
    @include('front.components.header_detail',['title'=> $question->title ])
    <div class="container">
        @include('front.components.float_btn',['question'=>$question])
        <div class="row">
            <div class="post-header">
                <h1 class="post-title">
                    {{ $question->title }}
                </h1>

                <div class="post-meta mb-2">
                    @foreach($question->categories as $category)
                        <span class="badge">{{ $category->name }}</span>
                    @endforeach
                </div>
                <div class="post-meta">
                    <span class="meta-item">
                        <i class="fa fa-calendar-o"></i> {{ $question->created_at->format('l, d F Y') }}
                    </span>
                    <span class="meta-item">
                        <i class="fa fa-eye"></i> {{ $question->views }}x Dibaca
                    </span>
                </div>
            </div>
        </div>
        <div class="bar-space"></div>
        <div class="row" style="margin-left: 10px;margin-rigth:10px">
            <div class="col">
                <small>Penanya</small>
                <p>{!! $question->content !!}</p>
            </div>
        </div>
        @if($question->answers->count() > 0)
            @foreach($question->answers as $answer)
                <div class="row" style="margin-left: 10px;margin-right:10px">
                    <div class="col">
                        <small>Jawaban</small>
                        <p>{!! $answer->content !!}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="profile-card">
                            <div class="profile-image"></div>
                            <div class="profile-text">
                                <strong>{{ $answer->user->name }}</strong><br>
                                <span>{{ $answer->user->ustadzDetail->bio ?? 'Ustadz' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row" style="margin-left: 10px;margin-right:10px">
                <div class="col">
                    <p>Belum ada jawaban untuk pertanyaan ini.</p>
                </div>
            </div>
        @endif

        <br>
        <div class="row">
            <div class="col">
                <div class="title-bar">
                    <p class="kiri"><b>Pertanyaan Terkait</b></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container-horizontal">
                @foreach($question->categories->first()->questions->take(10) as $relatedQuestion)
                    <div class="card">
                        <div class="card-body">
                            <div class="title-bar-card">
                                <span class="kiri">{{ $relatedQuestion->categories->first()->name }}</span>
                                <a href="#" class="kanan">{{ $relatedQuestion->created_at->format('d F Y') }}</a>
                            </div>
                            <div class="content-card">
                                <span class="title"><b>{{ $relatedQuestion->title }}</b></span><br>
                                <span class="des">{{ Str::limit($relatedQuestion->content, 100) }}</span><br>
                                <a href="{{ route('questions.show', $relatedQuestion->slug) }}" class="detail">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <div class="button-container">
                    <a href="{{ route('questions.create') }}" class="teal-button">Ajukan Pertanyaan</a>
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>
@endsection
