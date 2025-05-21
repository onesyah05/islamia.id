<style>
    /* Floating container - fixed di bagian bawah */
    .floating-container {
        position: fixed;
        bottom: 0;
        left: 60%;
        /* transform: translateX(-50%); */
        /* width: 100%; */
        max-width: 480px;
        height: 65px;
        /* background-color: #ffffff; */
        display: flex;
        justify-content: right;
        align-items: center;
        padding: 20px;
        margin-bottom: 20px;
        z-index: 1000;
    }

    /* Tombol bulat utama */
    .fab-main {
        background-color: #1abc9c;
        border: none;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 2;
    }

    .fab-main:hover {
        transform: scale(1.05);
    }

    /* Pill menu */
    .fab-menu {
        position: absolute;
        bottom: 0;
        /* Posisi tepat di atas tombol utama */
        background-color: #1abc9c;
        border-radius: 35px;
        width: 70px;
        height: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        opacity: 0;
        transform: scale(0.5);
        transform-origin: bottom center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        padding: 0;
    }

    /* Tombol dalam menu */
    .fab-sub {
        background: transparent;
        border: none;
        width: 44px;
        height: 44px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .fab-sub:hover {
        transform: scale(1.1);
    }

    /* Tombol close */
    .fab-close {
        background: transparent;
        border: none;
        width: 44px;
        height: 44px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        cursor: pointer;
        transition: transform 0.3s ease;
        margin-bottom: 12px;
    }

    .fab-close:hover {
        transform: rotate(90deg);
    }

    /* Divider untuk pill */
    .divider {
        width: 20px;
        height: 1px;
        background-color: rgba(255, 255, 255, 0.3);
    }

    /* Animasi ketika menu terbuka */
    .fab-open .fab-menu {
        height: 220px;
        padding: 20px 0;
        bottom: 0;
        opacity: 1;
        transform: scale(1);
    }

    .fab-open .fab-main {
        transform: scale(0);
        opacity: 0;
        visibility: hidden;
    }

    .fab-open .fab-close {
        opacity: 1;
        transform: scale(1);
        transition-delay: 0.1s;
    }

    /* SVG icons */
    .button-icon {
        width: 24px;
        height: 24px;
        stroke: white;
        stroke-width: 2;
        fill: none;
    }
</style>
<div class="floating-container" id="floatingContainer">
    <!-- Tombol bulat utama -->
    <button class="fab-main" id="fabMain" onclick="toggleFabMenu()">
        <svg class="button-icon" viewBox="0 0 24 24">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </button>

    <!-- Pill-shaped menu -->
    <div class="fab-menu" id="fabMenu">
        <!-- Tombol close di atas -->
        <button class="fab-close" onclick="toggleFabMenu()">
            <svg class="button-icon" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <!-- Tombol panah atas -->
        <button class="fab-sub">
            <a href="{{ route('bookmarks.store', $question->id) }}"><img style="width: 24px" src="{{ asset('icons/vector.png') }}" alt="" srcset=""></a>
        </button>

        <!-- Divider -->
        {{-- <div class="divider"></div> --}}

        <!-- Tombol download -->
        <button class="fab-sub">
            <a href="#"><img style="width: 24px" src="{{ asset('icons/download.png') }}" alt="" srcset=""></a>
        </button>
    </div>
</div>

<script>
    function toggleFabMenu() {
        document.querySelector('.floating-container').classList.toggle('fab-open');
    }
</script>
