<div class="bottom-nav">
    <div class="nav-icon {{ (Route::is('home')) ? 'active' : '' }}"><a href="/"><img src="{{ asset('icons/fi-home.png') }}" alt="" srcset=""></a></div>
    <div class="nav-icon {{ (Route::is('ask')) ? 'active' : '' }}"><a href="/ask"><img src="{{ asset('icons/fi-comments.png') }}" alt="" srcset=""></a></div>
    <div class="nav-icon {{ (Route::is('collaction')) ? 'active' : '' }}"><a href="/collaction"><img src="{{ asset('icons/fi-bookmark.png') }}" alt="" srcset=""></a></div>
    <div class="nav-icon"><img src="{{ asset('icons/fi-e-learning.png') }}" alt="" srcset=""></div>
    <div class="nav-icon">
        <div class="not"></div>
        <img src="{{ asset('icons/fi-user.png') }}" alt="" srcset="">
    </div>
</div>
