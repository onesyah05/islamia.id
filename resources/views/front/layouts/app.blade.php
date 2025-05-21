<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/custome.css') }}">
    <meta name="description" content="Platform tanya jawab seputar Islam">
    <meta name="keywords" content="islam, tanya jawab, fatwa, ustadz">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesian">
    <meta name="revisit-after" content="7 days">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    @yield('meta')
</head>
<style>
    .alert{
        margin: 10px;
        z-index: 10000;
    }
</style>
<body>
    <!-- Main Content -->
    <div class="app-container">

        <!-- Flash Messages -->
    

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-info">
                {{ session('status') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        @yield('content')

        @if (!Route::is('questions.show') && !Route::is('search.questions'))
            @include('front.components.bottomnav')
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Debug session data in console
        console.log('Session Data:', @json(session()->all()));

        // Auto hide alerts after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
