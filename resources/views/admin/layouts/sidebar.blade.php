<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ url('/') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <svg
          width="25"
          viewBox="0 0 25 42"
          version="1.1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
        >
          <!-- SVG content (same as original) -->
        </svg>
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ config('app.name', 'Sneat') }}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->

      <li class="menu-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <a href="{{ route('dashboard.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div>Dashboard</div>
        </a>
      </li>
      <li class="menu-header small text-uppercase"><span>Manajemen</span></li>
      <li class="menu-item"><a href="{{ route('dashboard.users.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-user"></i><div>User</div></a></li>
      {{-- <li class="menu-item"><a href="{{ route('dashboard.ustadz') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-user-voice"></i><div>Ustadz</div></a></li> --}}
      <li class="menu-item"><a href="{{ route('dashboard.questions.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-question-mark"></i><div>Pertanyaan</div></a></li>
      {{-- <li class="menu-item"><a href="{{ route('dashboard.notifications') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-bell"></i><div>Notifikasi</div></a></li> --}}
      {{-- <li class="menu-item"><a href="{{ route('dashboard.reports') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-bar-chart"></i><div>Statistik & Laporan</div></a></li> --}}
      <li class="menu-item"><a href="{{ route('dashboard.settings') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-cog"></i><div>Pengaturan</div></a></li>
    
      {{-- <li class="menu-item {{ request()->routeIs('dashboard.ustadz.questions.inbox') ? 'active' : '' }}">
        <a href="{{ route('dashboard.ustadz.questions.inbox') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div>Dashboard</div>
        </a>
      </li>
      <li class="menu-item"><a href="{{ route('dashboard.ustadz.questions.inbox') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-inbox"></i><div>Pertanyaan Masuk</div></a></li>
      <li class="menu-item"><a href="{{ route('dashboard.ustadz.questions.answered') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-check-circle"></i><div>Sudah Dijawab</div></a></li>
      <li class="menu-item"><a href="{{ route('dashboard.ustadz.bookmark') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-bookmark"></i><div>Bookmark</div></a></li>
      <li class="menu-item"><a href="{{ route('dashboard.ustadz.notifications') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-bell"></i><div>Notifikasi</div></a></li>
      <li class="menu-item"><a href="{{ route('dashboard.ustadz.profile') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-user"></i><div>Profil Saya</div></a></li>
      <li class="menu-item"><a href="{{ route('dashboard.ustadz.profile.edit') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-edit"></i><div>Update Profil</div></a></li> --}}
    
    <!-- Logout -->
    <li class="menu-item">
      <a href="{{ route('logout') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-power-off"></i>
        <div>Logout</div>
      </a>
    </li>
  </ul>
</aside>