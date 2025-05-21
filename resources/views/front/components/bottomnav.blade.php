<div class="bottom-nav">
    <div class="nav-icon {{ (Route::is('home')) ? 'active' : '' }}"><a href="/"><img src="{{ asset('icons/fi-home.png') }}" alt="" srcset=""></a></div>
    <div class="nav-icon {{ (Route::is('questions')) ? 'active' : '' }}"><a href="{{ Route('questions.index') }}"><img src="{{ asset('icons/fi-comments.png') }}" alt="" srcset=""></a></div>
    <div class="nav-icon {{ (Route::is('bookmarks.index')) ? 'active' : '' }}"><a href="/bookmarks"><img src="{{ asset('icons/fi-bookmark.png') }}" alt="" srcset=""></a></div>
    <div class="nav-icon"><img src="{{ asset('icons/fi-e-learning.png') }}" alt="" srcset=""></div>
    <div class="nav-icon {{ (Route::is('account')) ? 'active' : '' }}">
        <div class="not"></div>
        <a href="{{ route('account') }}"><img src="{{ asset('icons/fi-user.png') }}" alt="" srcset=""></a>
    </div>
</div>
